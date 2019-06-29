from sklearn.datasets import fetch_20newsgroups
from sklearn.feature_extraction.text import CountVectorizer
from sklearn.feature_extraction.text import TfidfTransformer
from sklearn.naive_bayes import MultinomialNB
from sklearn.pipeline import Pipeline
import numpy as np

## TRAINING DATA and CATEGORIES
categories = ['alt.atheism', 'soc.religion.christian','comp.graphics', 'sci.med']
twenty_train = fetch_20newsgroups(subset='train',categories=categories, shuffle=True, random_state=42)
# print("\n".join(twenty_train.data[0].split("\n")[:3]))
# print(twenty_train.target_names[twenty_train.target[0]])
# print(twenty_train.target[:10])

## TOKENIZING
# count_vect = CountVectorizer()
# print(count_vect.vocabulary_.get(u'algorithm'))
# X_train_counts = count_vect.fit_transform(twenty_train.data)
# print(X_train_counts.shape)

## TF TRANSFORMER
# tf_transformer = TfidfTransformer(use_idf=False).fit(X_train_counts)
# X_train_tf = tf_transformer.transform(X_train_counts)
# print(X_train_tf.shape)

## METHODE
# clf = MultinomialNB().fit(X_train_tf, twenty_train.target)
# docs_new = ['God is love', 'OpenGL on the GPU is fast']
# X_new_counts = count_vect.transform(docs_new)
# X_new_tf = tf_transformer.transform(X_new_counts)
# predicted = clf.predict(X_new_tf)
# for doc, category in zip(docs_new, predicted):
#     print('%r => %s' % (doc, twenty_train.target_names[category]))

## PIPELINE (FAST WAY)
text_clf = Pipeline([('vect', CountVectorizer()),
                     ('tfidf', TfidfTransformer(use_idf=False)),
                     ('clf', MultinomialNB()),
])
text_clf.fit(twenty_train.data, twenty_train.target)

# ## TESTING DATA
twenty_test = fetch_20newsgroups(subset='test',categories=categories, shuffle=True, random_state=42)
docs_test = twenty_test.data
predicted = text_clf.predict(docs_test)
print (np.mean(predicted == twenty_test.target))
