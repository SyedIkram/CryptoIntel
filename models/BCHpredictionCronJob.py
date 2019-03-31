import pandas as pd
import datetime
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

    SYM = 'BCH'
    SYM_id = 202330

    scaler = MinMaxScaler(feature_range=(0, 1))

    model = load_model('/home/tkapoor/Big_Data_2_project/models/'+SYM+'model.h5')

    url = 'https://min-api.cryptocompare.com/data/histoday?fsym='+SYM+'&tsym=USD&limit=1'
    page = requests.get(url)
    data_cc = page.json()

    t_close = data_cc['Data'][0]['close']
    t_high = data_cc['Data'][0]['high']
    t_low = data_cc['Data'][0]['low']
    t_open = data_cc['Data'][0]['open']
    t_volumefrom = data_cc['Data'][0]['volumefrom']
    t_volumeto = data_cc['Data'][0]['volumeto']
    t_weightedprice = (t_close+t_high+t_low+t_open)/4


    data_pred=np.array([[t_close,t_high,t_low,t_open,t_volumefrom,t_volumeto,t_weightedprice]])
    a=scaler.fit_transform(data_pred)
    pre=model.predict(a.reshape(data_pred.shape[0],1,7))
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

    query = "INSERT INTO predictedprice (id,price,symbol) VALUES ("+str(SYM_id)+","+ str(df['predicted_weight'][0])+",'"+SYM+"');"
    future = session.execute(query)