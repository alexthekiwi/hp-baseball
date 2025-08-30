---
id: 9af2f176-531d-4f3b-8ba8-e0bc904357ef
blueprint: article
title: 'Introducing Dynamic Asset Folders!'
thumbnail: dynamic-asset-folders.jpg
author: 1
bard:
  -
    type: paragraph
    content:
      -
        type: text
        text: "With Statamic v5.27.0, we've introduced a new feature with photography, gallery, and portfolio sites in mind, but can help enhance the organization of your assets across the board, no matter the type of site."
  -
    type: heading
    attrs:
      level: 2
    content:
      -
        type: text
        marks:
          -
            type: bold
        text: 'How Dynamic Asset Folders Work'
  -
    type: paragraph
    content:
      -
        type: text
        text: "By enabling this feature on an Assets Field, each entry will automatically create a new sub-folder to store its assets in. You can set it to use the Entry's "
      -
        type: text
        marks:
          -
            type: code
        text: slug
      -
        type: text
        text: ', '
      -
        type: text
        marks:
          -
            type: code
        text: id
      -
        type: text
        text: ', or '
      -
        type: text
        marks:
          -
            type: code
        text: author
      -
        type: text
        text: ' field to generate the folder name from.'
  -
    type: paragraph
    content:
      -
        type: image
        attrs:
          src: 'asset::assets::dynamic-folder-blueprint-builder.jpg'
          alt: null
  -
    type: paragraph
    content:
      -
        type: text
        text: "Now, each blog post in your Collection will store its images and other assets (like PDFs) in an auto-generated folder named after the slug of your blog post. Let's say you're running a wedding photography website. You have a Galleries collection and your latest wedding is a new entry titled "
      -
        type: text
        marks:
          -
            type: code
        text: 'Kate and Johnny'
      -
        type: text
        text: ', which would (unless you edit it), use the slug would be '
      -
        type: text
        marks:
          -
            type: code
        text: kate-and-johnny
      -
        type: text
        text: .
  -
    type: paragraph
    content:
      -
        type: text
        text: 'Now, all the photos you upload into your Photos Assets field will be uploaded into '
      -
        type: text
        marks:
          -
            type: code
        text: /img/galleries/kate-and-johnny/
      -
        type: text
        text: ". If you decide to add more later or deselect some, you don't have to browse through all of your potentially thousands of images to find the right ones, and the changes of uploading two "
      -
        type: text
        marks:
          -
            type: code
        text: IMG_7337.jpg
      -
        type: text
        text: ' files goes down to next to zero.'
  -
    type: paragraph
    content:
      -
        type: text
        text: 'Instead of having your asset containers being unstructured and cluttered with all kinds of random files, they can now look like this:'
  -
    type: paragraph
    content:
      -
        type: image
        attrs:
          src: 'asset::assets::auto-generated-folder-structure.png'
          alt: null
  -
    type: paragraph
    content:
      -
        type: text
        text: "This works flawlessly with Statamic's and Laravel's powerful adapter-based filesystem approach. Whether you store your assets locally on the server or use an object storage like AWS S3 or one of its many API-compatible alternatives, this will "
      -
        type: text
        marks:
          -
            type: bold
        text: 'just work™'
      -
        type: text
        text: .
  -
    type: paragraph
    content:
      -
        type: text
        text: "If you're interested in the implementation details, head over to GitHub and "
      -
        type: text
        marks:
          -
            type: link
            attrs:
              href: 'https://github.com/statamic/cms/pull/10808'
              rel: null
              target: null
              title: null
          -
            type: underline
        text: 'the corresponding PR'
      -
        type: text
        text: .
  -
    type: heading
    attrs:
      level: 3
    content:
      -
        type: text
        marks:
          -
            type: bold
        text: 'Also in the works...'
  -
    type: paragraph
    content:
      -
        type: text
        text: "We are also tinkering with a brand new photography-centric Starter Kit that will utilize this feature. We think you're going to love it."
  -
    type: heading
    attrs:
      level: 2
    content:
      -
        type: text
        marks:
          -
            type: bold
        text: 'Let Us Know Your Thoughts'
  -
    type: paragraph
    content:
      -
        type: text
        text: 'Like other features, this one was a community request that got submitted via our '
      -
        type: text
        marks:
          -
            type: link
            attrs:
              href: 'https://github.com/statamic/ideas/issues'
              rel: null
              target: null
              title: null
          -
            type: underline
        text: statamic/ideas
      -
        type: text
        text: ' repo. Is there a specific feature you wish were in Statamic? '
      -
        type: text
        marks:
          -
            type: bold
        text: 'Feel free to open a feature request'
      -
        type: text
        text: ' on the repository. Please make sure to search first to avoid duplicates.'
  -
    type: paragraph
    content:
      -
        type: text
        text: 'Questions about this feature or anything else Statamic? Hop on '
      -
        type: text
        marks:
          -
            type: link
            attrs:
              href: 'https://statamic.com/discord'
              rel: null
              target: null
              title: null
          -
            type: underline
        text: 'our community Discord'
      -
        type: text
        text: ", and don't forget to "
      -
        type: text
        marks:
          -
            type: link
            attrs:
              href: 'https://statamic.com/newsletter/archive'
              rel: null
              target: null
              title: null
          -
            type: underline
        text: 'subscribe to our newsletter'
      -
        type: text
        text: ' to get updates right into your inbox.'
date: '2024-09-30'
updated_by: 1
updated_at: 1747801264
excerpt: 'Having a content-heavy site with lots resources and assets? Our new dynamic asset folder creation to the rescue!'
tags:
  - update
---
