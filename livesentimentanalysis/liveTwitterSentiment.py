import requests
import pandas as pd
import json
import time
import os
import sys
import csv
import datetime
from pandas.io.json import json_normalize
from pytz import timezone
import math
import tweepy
from tweepy import Stream
from tweepy import OAuthHandler
from tweepy.streaming import StreamListener
from unidecode import unidecode
from textblob import TextBlob


# def roundDT(num):
#     return int(math.ceil(num/10.0)) * 10
    
# def convertToPst(inp_time):
#     curDate = datetime.datetime.fromtimestamp(roundDT(int(int(inp_time) / 1000.0)))\
#         .astimezone(timezone('US/Pacific')).strftime('%Y-%m-%d')
#     curTime = datetime.datetime.fromtimestamp(roundDT(int(int(inp_time) / 1000.0)))\
#         .astimezone(timezone('US/Pacific')).strftime('%H:%M:%S')
#     return curDate,curTime

def makeHeader(file_name,header_list):
    try:
        with open(file_name, 'a', newline = '') as f:
            writer = csv.writer(f)
            writer.writerow(header_list)
    except KeyError as e:
        print(str(e))
    return True
    
def pdToCSV(file_name_c,in_data):
    try:
        with open(file_name_c, 'a', newline = '') as f:
            writer = csv.writer(f)
            writer.writerow(in_data)
    except KeyError as e:
        print(str(e))
    return True

COUNT = 0
x = 0
y = 0
cC = 0

class listener(StreamListener):
    
    def on_data(self, data):
        try:
            global x
            global y
            global cC
            data = json.loads(data)
            tweet = unidecode(data['text'])
            # curDate,curTime = convertToPst(data['timestamp_ms'])
            
            analysis = TextBlob(tweet)
            sentiment = analysis.sentiment.polarity
            
            x += .11
            if sentiment > 0:
                posNeg = 'Positive'
                y += .25
            elif sentiment < 0:
                posNeg = 'Negative'
                y -= 1
            else:
                posNeg = 'Neutral'
                y += 0

            pdToCSV(file_name,[x,y])

        except KeyError as e:
            print(str(e))

        return True

if __name__ == "__main__":
    topic = sys.argv[1]
    mainFlag = int(sys.argv[2])

    global file_name
    file_name = '/Applications/XAMPP/xamppfiles/htdocs/upgraph/' + topic+'_data.csv'
    header_list = ['date','close']
    
    consumer_key = '7ipQzsOTw3jvxyTBd4fDpD59w'
    consumer_secret = 'NN34XgoWDEAjqZJB0Td8RttmIkzX0uYdDeqDK8f9ooha3bGfI1'


    access_token = '4138613354-WEtZ59AIviF2yg1weQdd2JdlGPTrjTW9CgVfdK3'
    access_token_secret = 'RjmWAMYUGS1RUYv89NXRM38hNEO27gmqkA6dx2s0dOiWr'

    if mainFlag == 1:
        makeHeader(file_name,header_list)

    if mainFlag == 2:
        os.remove(file_name)
        makeHeader(file_name,header_list)

    while(True):
        try:
            auth = OAuthHandler(consumer_key, consumer_secret)
            auth.set_access_token(access_token, access_token_secret)
            twitterStream = Stream(auth, listener())
            time.sleep(5)
            twitterStream.filter(track = [topic]) 
            
        except Exception as e:
            print(str(e))
