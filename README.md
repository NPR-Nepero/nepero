# nepero

Website of the NePeRo initiative.

The website is built with [Jekyll](https://jekyllrb.com/docs/).

- 	To serve it locally, run
	```
	bundle exec jekyll serve
	```
	from the cloned repository.

- 	To add a bibliography entry, add a line in the file `_include/refs.md` in the form
	```
	[^keyword]: Author. "[Title](https://doi.org/XX.XXXX/XXXXXXX)". In: *Journal* Vol, p. (YYYY)
	```
	In the markdown page where you want to link the article, use the keyword to link the article:
	```
	example sentence.[^keyword]
	```
	and make sure to include the file `refs.md` at the bottom:
	```
	{% include refs.md %}
	```
