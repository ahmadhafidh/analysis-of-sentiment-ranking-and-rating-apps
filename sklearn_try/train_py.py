from sklearn.feature_extraction.text import CountVectorizer
from sklearn.feature_extraction.text import TfidfTransformer
from sklearn.naive_bayes import MultinomialNB
import mysql.connector
import pickle as pi

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  passwd="",
  database="project"
)

train_data=list()
kategori=list()
mycursor = mydb.cursor()
mycursor.execute("SELECT * FROM dataset_baru")
myresult = mycursor.fetchall()
for (id_teks, teks, label) in myresult:
    train_data.append(teks)
    kategori.append(label)

## TOKENIZING
count_vect = CountVectorizer()
X_train_counts = count_vect.fit_transform(train_data)
filobjek=open("sklearn_try/train_count",'wb')
pi.dump(X_train_counts,filobjek)
filobjek.close()
# print(X_train_counts)

filobjek=open("sklearn_try/train_data",'wb')
pi.dump(train_data,filobjek)
filobjek.close()
# print(train_data)

## TF TRANSFORMER
tf_transformer = TfidfTransformer().fit(X_train_counts)
X_train_tf = tf_transformer.transform(X_train_counts)

# Simpan Model Training
clf = MultinomialNB().fit(X_train_tf, kategori)
filobjek=open("sklearn_try/model_train",'wb')
pi.dump(clf,filobjek)
filobjek.close()