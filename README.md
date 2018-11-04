[![Build Status](https://travis-ci.org/vpx/google-places-api-example.svg?branch=master)](https://travis-ci.org/vpx/google-places-api-example)

## Overview

Simple example of using the Google Places API.

## Task 
* The project is to implement a web service in PHP that provides search results from the Google Places API. 
* The service provides the response to a location based area search as defined below. 
* The service returns results of content type application/json from a get request submitted through the url.

### Find businesses in an area

*Input:* URL GET request of search terms

*Returns:* name and address only as content type application/json. Given a query such as “burritos in Berlin” or “ramen in Tokyo” returns a list of establishment names and address.
The response does not return additional information.

**Notes:**
* handle connection problems to the Google Places API gracefully.
* use an object oriented approach
* simple and elegant design, KISS, YAGNI
* PHPDoc style comments
* do **not** use any existing PHP frameworks
* do **not** create a web form
* do **not** support the optional Google API parameters location, radius, language, etc.

*Example url call: http://localhost/places/mymethod1?myParam=myValue*

## Installation

### Docker & Docker Compose

#### Ubuntu

Look here https://docs.docker.com/installation/ubuntulinux/#ubuntu-trusty-1404-lts-64-bit

#### MacOS

Look here
* https://beta.docker.com
* https://docs.docker.com/installation/mac
* https://github.com/dduportal/boot2docker-vagrant-box
* https://kitematic.com

### Build environment

```sh
$ cd <project folder>
$ make setup-docker
```

or
```sh
$ cd <project folder>
$ docker-compose up -d
```

## Access container shell

```sh
$ docker exec -it gpa /bin/bash
```

## Testing

```sh
$ docker exec -it gpa make test
```

#### If you don't want using docker you can config your own web-server. Just use [this](/docker/nginx/vhost.conf) nginx config. 

### Examples
* http://localhost/places/search?query=auto1+Berlin
* http://localhost/places/search?query=burritos+in+Berlin
* http://localhost/places/search?query=ramen+in+Tokyo
