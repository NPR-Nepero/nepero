---
layout: default
title: Posts
---

## Posts

<ul class="post-list">
  {% for post in site.posts %}
    <li class="post-item">
      <a href="{{ post.url | relative_url }}">{{ post.title }}</a>
      <span class="post-date">— {{ post.date | date: "%Y-%m-%d" }}</span>

      {% if post.abstract %}
        <p class="post-abstract">{{ post.abstract | escape }}</p>
      {% elsif post.excerpt %}
        <p class="post-abstract">{{ post.excerpt | strip_html | truncate: 200 }}</p>
      {% endif %}
    </li>
  {% endfor %}
</ul>
