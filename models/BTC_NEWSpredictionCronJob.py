import pandas as pd
from textblob import TextBlob
import datetime
from pandas.io.json import json_normalize
import numpy as np
from cassandra.cluster import Cluster
from cassandra.query import SimpleStatement
from sklearn.preprocessing import MinMaxScaler
from keras.models import load_model
import requests

if __name__ == "__main__":
    cluster = Cluster(['127.0.0.1'],load_balancing_policy=None)
    session = cluster.connect()
    session.set_keyspace('crypton') 

    SYM = 'BTC'
    SYM_id = 1182

    scaler = MinMaxScaler(feature_range=(0, 1))

#     model = load_model('/home/tkapoor/Big_Data_2_project/models/BTC_news_model.h5')
    model = load_model('BTC_news_model.h5')
    
    url = 'https://min-api.cryptocompare.com/data/histoday?fsym=BTC&tsym=USD&limit=1'
    page = requests.get(url)
    data_cc = page.json()

    url_news = 'https://min-api.cryptocompare.com/data/v2/news/?lang=EN&categories=BTC'
    page_news = requests.get(url_news)
    data_cc_news = page_news.json()


    df_news = json_normalize(data_cc_news["Data"])

    df_news['senti'] = (df_news['body']+df_news['title']).apply(lambda x: TextBlob(str(x)).sentiment.polarity)


    t_close = data_cc['Data'][0]['close']
    t_high = data_cc['Data'][0]['high']
    t_low = data_cc['Data'][0]['low']
    t_open = data_cc['Data'][0]['open']
    t_weightedprice = (t_close+t_high+t_low+t_open)/4
    t_sentiment = df_news['senti'].sum()

    data_pred=np.array([[t_close,t_high,t_low,t_open,t_sentiment,t_weightedprice]])
    a=scaler.fit_transform(data_pred)
    pre=model.predict(a.reshape(data_pred.shape[0],1,6))
    phat=np.concatenate((pre,a[:,1:]),axis=1)
    predicted=scaler.inverse_transform(phat)

    predicted_weight=[]
    date=[]
    tomDate = str(datetime.date.today() + datetime.timedelta(1))
    date=pd.date_range(tomDate,tomDate,freq='D').sort_values(ascending=False)

    for i in range(data_pred.shape[0]):
        predicted_weight.append(predicted[i,0])
    df=pd.DataFrame({'Date':date})

    df['predicted_weight']=predicted_weight

    query = "INSERT INTO sentimentprice (id,price,symbol) VALUES ("+str(SYM_id)+","+ str(df['predicted_weight'][0])+",'"+SYM+"');"
    future = session.execute(query)