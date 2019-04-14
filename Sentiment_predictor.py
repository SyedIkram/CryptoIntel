#!/usr/bin/env python
# coding: utf-8

# In[181]:


import findspark
findspark.init()

import sys
assert sys.version_info >= (3, 5) # make sure we have Python 3.5+
import pandas as pd
import numpy as np
import re
import string
from textblob import TextBlob

from pyspark.sql import SparkSession, functions, types
spark = SparkSession.builder.appName('Emotion prediction').getOrCreate()
spark.sparkContext.setLogLevel('WARN')
assert spark.version >= '2.3' # make sure we have Spark 2.3+
from pyspark.sql.types import StringType
from pyspark.sql.functions import udf
from pyspark.ml.feature import StopWordsRemover
from pyspark.sql.functions import *
from pyspark.ml import Pipeline
from pyspark.ml.feature import StringIndexer, VectorAssembler, IndexToString
from pyspark.ml.classification import LogisticRegression
from pyspark.ml.evaluation import MulticlassClassificationEvaluator
from pyspark.ml.feature import CountVectorizer
from pyspark.ml.tuning import ParamGridBuilder, CrossValidator
from pyspark.sql.types import IntegerType
from pyspark.ml.feature import HashingTF, IDF, Tokenizer


# In[155]:


#!pip install textblob


# In[156]:


inputs = '/Users/syedikram/Documents/BigData-733/cryptointel/news_cc/btcnews.csv'
data = spark.read.csv(inputs,header=True, mode="DROPMALFORMED")


# In[157]:


data = data.withColumn("title_body", concat_ws(' ', data.title, data.body))
lower_udf = udf(lambda x: " ".join(x.lower() for x in x.split()))
data = data.withColumn("title_body", lower_udf(data['title_body']))


# In[158]:


def remove_punct(text):
    regex = re.compile('[' + re.escape(string.punctuation) + '0-9\\r\\t\\n]')
    nopunct = regex.sub(" ", text)
    return nopunct


# In[159]:


punct_remover = udf(lambda x: remove_punct(x))


# In[160]:


data = data.withColumn("title_body", punct_remover(data['title_body']))


# In[161]:


spaces_udf = udf(lambda x: " ".join(x.split()))
data = data.withColumn("title_body", spaces_udf(data['title_body']))


# In[162]:


sentiment_udf = udf(lambda x: 1 if TextBlob(str(x)).sentiment.polarity > 0 else (0 if TextBlob(str(x)).sentiment.polarity == 0 else -1))


# In[163]:


data = data.withColumn("sentiment", sentiment_udf(data['title_body']))
data = data.select('title_body','sentiment')


# In[164]:


#Tokenizing and Vectorizing
tok = Tokenizer(inputCol="title_body", outputCol="words")
tokenized = tok.transform(data)


# In[165]:


stopword_rm = StopWordsRemover(inputCol='words', outputCol='words_rm')
rm_tokenized = stopword_rm.transform(tokenized)


# In[166]:


cv = CountVectorizer(inputCol='words_rm', outputCol='tf')
cvModel = cv.fit(rm_tokenized)
count_vectorized = cvModel.transform(rm_tokenized)


# In[167]:


idf_ngram = IDF().setInputCol('tf').setOutputCol('tfidf')
tfidfModel_ngram = idf_ngram.fit(count_vectorized)
tfidf_df = tfidfModel_ngram.transform(count_vectorized)


# In[168]:


indexer = StringIndexer(inputCol="sentiment", outputCol="sentimentIndex")
indexed = indexer.fit(data).transform(data)
indexed.show()


# In[169]:


splits = tfidf_df.randomSplit([0.8,0.2],seed=100)
train = splits[0]
val = splits[1]


# In[170]:


train.show()


# In[174]:


hm_assembler = VectorAssembler(inputCols=[ "tfidf"], outputCol="features")
lr = LogisticRegression(maxIter=20, regParam=0.3, elasticNetParam=0,labelCol="sentimentIndex",featuresCol = "features")
hm_pipeline = Pipeline(stages=[hm_assembler, indexer, lr])


# In[175]:


paramGrid = ParamGridBuilder().addGrid(lr.regParam, [0.1, 0.3]).addGrid(lr.elasticNetParam, [0.0, 0.1]).build()
crossval = CrossValidator(estimator=hm_pipeline,estimatorParamMaps=paramGrid,            evaluator=MulticlassClassificationEvaluator(labelCol="sentimentIndex", predictionCol="prediction",metricName="accuracy"),numFolds=5)

model = crossval.fit(train)
prediction_train = model.transform(val)


# In[176]:


evaluator = MulticlassClassificationEvaluator(labelCol="sentimentIndex", predictionCol="prediction",
                                              metricName="accuracy")
accuracy = evaluator.evaluate(prediction_train)
print("Model Accuracy = " + str(accuracy))


# In[186]:


converter = IndexToString(inputCol="sentimentIndex", outputCol="originalSentiment")
converted = converter.transform(indexed)
converted.select('title_body','sentiment','originalSentiment').show(10)


# In[ ]:




