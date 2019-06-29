from sklearn.datasets import fetch_20newsgroups
newsgroups_train = fetch_20newsgroups(subset='train')

from pprint import pprint
pprint(list(newsgroups_train.target_names))

cats = ['alt.atheism', 'sci.space']
newsgroups_train = fetch_20newsgroups(subset='train', categories=cats)

list(newsgroups_train.target_names)

newsgroups_train.filenames.shape

newsgroups_train.target.shape

newsgroups_train.target[:10]