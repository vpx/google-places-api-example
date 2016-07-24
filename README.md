## Overview

Simple example of using the Google Places API.

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

### Examples
* http://localhost/places/search?query=auto1+Berlin
* http://localhost/places/search?query=burritos+in+Berlin
* http://localhost/places/search?query=ramen+in+Tokyo
