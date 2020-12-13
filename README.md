# REST API

REST API: Simples API using Phalcon Framework

## Motivation

I decided to create a simple API from scratch to demonstrate my way of programming and applying OOP concepts and best practices. As well as DevOps concepts and tests. The pipelines were made to run in GitLab.

See original repository in GitLab [here](https://gitlab.com/jmsilvadev/ixdf)


### User History

This project is based in this user history:

```
AS an User
I WANT TO access an API to get students and courses and creates them too.

Notes:
- The API must follow REST
- Must provide tests and coverage
- Must provide an automated pipeline
- Must follow the Testing Guidelines and Code Style Guidelines
- Must Use a Cache System to reduce costs with cloud servers
```

Test Guidelines: you can read [here](Tests-Guideline.pdf)
 
Code Style: you can read [here](CodingSytle-PHP.pdf)

## How To Use

### Start Environment

To use the system, simple Type `make up` to start the container
and `make down` to stop it.

```bash
make up
make down
```

### Accessing API

After start the conteiner, you can access the API, using any http client,
connect in this address `http://localhost:8080/students/`. For example using CURL:

```
curl http://localhost:8080/students/
```

If something wrong occurs, see the Setup Section below, to ensure that all initial steps were made.

To know all endpoint, see OAS bellow.

### Open API Specification

This api use OAS and it spec can be visualized in the openapi.json [here](https://gitlab.com/jmsilvadev/ixdf-api/-/blob/master/openapi.json) file and and through the endpoint `/oas`.


## Development

### Semantic Versioning

The API uses the automatic versioning system, which facilitates version control by minimizing breaks, providing faster and more effective regression resources and increasing the power of deploys. Every time a merge request is accepted, the pipeline will generate a TAG and store it in the repository. The tags can be viewed [here](https://gitlab.com/jmsilvadev/ixdf/-/tags).


### Cache System

The API uses the self-managing dynamic cache system using Redis. Every time a GET request arrives at the API it checks if there is already a cache for the call and if so, it returns the cache value, if not, it passes the request to the API and at the end of the cycle caches the response. When the API receives action verbs like POST / PUT, the cache system automatically invalidates only the affected endpoints. In this way, the API has a fully automated cache management, significantly reducing the traffic and use of the computational resources of the servers.


### DevOps

The API was conceived within the devops culture using continuous integration and continuous delivery through automated pipelines. The entire environment is containerized and easily manipulated through a Makefile file.
Pipelines can be viewed [here](https://gitlab.com/jmsilvadev/ixdf/-/pipelines).


### Setup project

To set up an API container you should download the source code from
git and install it.

The `make install` should be only used once. It will install all the
dependences and insert the fake data to the database.
After this, you should only use the `make up` & `make down` to controll your
container.

You are now ready to use the system. Type `make up` to start the container
and `make down` to stop it.

### Build tools

Build the image

```bash
make build
```

### Composer

To install / update or add composer dependencies:

```bash
make composer.install
make composer.update
```

### Code Quality

PHP Metrics:

```bash
make php.metrics
```

PHP CS:

```bash
make php.cs
```

PHP CBF:

```bash
make php.cbf
```

PHP MD:

```bash
make php.md
```

### Tests

Last Coverage: 
![alt text](code-coverage.png "Coverage")

Run all tests suite

```bash
make test
```

Run specifit test suits

```bash
make test.unit ## unit tests suite
make test.coverage ## coverage
```

### Migrations (DB)

To create DB Structure (Migrations):

```bash
make createdb
```


```bash
make db.migrate
```

### MakeFile

To make our tools abstract to the intentions we use simple make commands to
perform tasks like: launch a test suite.
Example:.

```bash
make test
```

To learn all the commands the MakeFile can do just use the command
`make` or `make help`



# Extras


## 1. How do you decide when the test coverage of a given feature is good enough? How do you decide what should be tested and what sort of tests should be used?

For me, code coverage should be at least 95% with a CRAP index as low as possible. For me, it is not feasible to have a low code coverage since the use of TDD forces you to do your tests even before the code. :) That is, at the end of the development cycle your coverage must be at least 70%, that is why we know that the first tests are done so that the functionality passes, but then there must be validation tests that will increase this percentage. My coverage is generally above 95% in production systems, and the remaining 5% are pieces of code that do not have an advantageous cost / benefit ratio, that is, it would be very complex to develop a code to cover a line that would be, for example , a throw. Attached is the test guideline that I always try to apply to the companies I go to.

## 2. How do you reduce code coupling?

In a simple and quick answer, decouple :D But to make an efficient decoupling it is necessary to know the concepts of Afferent Coupling (CA), Efferent Coupling (CE), Instability and above all S.O.L.I.D. The coupling occurs when a class depends on another class, in other words, it knows too much about the other class and this is very bad, because it leads to a concept called esparghetti code (I love esparghetti, but I hate code smell ;) ). So it is said that a class is strongly coupled when a change from another class breaks or behaves from this class (CE) or a change from this class breaks the behavior of another class (CA). In an object-oriented system the CA and the CE must always exist, however to maintain a stable system we must always be aware of the level of instability of the classes. A class always has to be more unstable than the class it depends on, but that's not all. In order to end a class's knowledge of other classes and decouple it, we know the principles of SOLID. What do we really need to do to have a decoupled system? Apply SOLID :D. First of all, a class must have a single purpose, it cannot do much, that is, if a class is only used to retrieve data from the user table, for example, it should only know how to do it therefore, it must not know how to make validations, calculations, or data persistence, that is, it must have a single responsibility, and this is the first principle of SOLID, SRP (Single Responsibility). In addition, a class should always depend on its abstractions, this will cause the eference to be reduced drastically, and to make a class depend on an abstraction, use the design pattern Depency Injection;), which does lead us to the D of SOLID (Dependency inversion principle). But, still, it is necessary to provide that a class uses an abstraction from another class and to guarantee thiswe can use the interface segmentation principle, that is, when applying interfaces to our classes, we can easily inject these interfaces into other classes instead of inserting concrete classes, amazing!, and do you know what the gain is? Stability, which leads us to another very important principle of SOLID, which is the principle of Open/Closed, a class must be open for access and closed for changes, now if a class has a high CA, any change in that class can compromise the stability of the system, so this class has to be protected for changes, and the best way to do that is using interfaces or abstract classes, we should only be careful of the correct use of abstract classes because its misuse can break the other principle of SOLID called the Liskov principle. ;)

In short, after so much talk, what is needed to reduce coupling, in simple words and briefly: classes must depend on their abstractions using the principle of inversion of dependency and have well-defined specific responsibilities.
