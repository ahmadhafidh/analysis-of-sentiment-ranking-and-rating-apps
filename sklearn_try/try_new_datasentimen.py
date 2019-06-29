from sklearn.feature_extraction.text import CountVectorizer
from sklearn.feature_extraction.text import TfidfTransformer
from sklearn.naive_bayes import MultinomialNB
from sklearn.pipeline import Pipeline
import pickle
import mysql.connector
import json

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  passwd="",
  database="project"
)

## TOKENIZING
count_vect = CountVectorizer()
filobjek=open("sklearn_try/train_data",'rb')
train_data=pickle.load(filobjek)
X_train_counts = count_vect.fit_transform(train_data)
# print(train_data)

## TF TRANSFORMER
filobjek=open("sklearn_try/train_count",'rb')
train_count=pickle.load(filobjek)
tf_transformer = TfidfTransformer().fit(train_count)
# print(train_count)

test_data=list()
mycursor = mydb.cursor()
mycursor.execute("SELECT * FROM data_crawling_baru")
myresult = mycursor.fetchall()
for id_crawl,konten,id_tes in myresult:
    test_data.append(konten)

filobjek=open("sklearn_try/model_train",'rb')
clff=pickle.load(filobjek)
X_new_counts = count_vect.transform(test_data)
X_new_tf = tf_transformer.transform(X_new_counts)
predicted = clff.predict(X_new_tf)

sentimen=list()
for doc, category in zip(test_data, predicted):
    # print('%r => %s' % (doc, category))
    sentimen.append(category)

pos=0
neg=0
for status in sentimen:
    if status=="positif":
        pos=pos+1
    elif status=="negatif":
        neg=neg+1


hasil_sentimen={"positif":pos,"negatif":neg}
json_sentimen=json.dumps(hasil_sentimen)
print(json_sentimen)