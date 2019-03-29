from pytrends.request import TrendReq
import sys




if __name__ == "__main__":
    pytrends = TrendReq(hl='en-US')
    pytrends.build_payload([sys.argv[1]],timeframe='2015-01-01 '+sys.argv[2])
    hourlyData = pytrends.interest_over_time().reset_index()
    hourlyData['date'] = hourlyData['date'].apply(lambda x: str(x)[:10] )
    del hourlyData['isPartial']
    print("["+hourlyData.to_json(orient='records')[1:-1]+"]")