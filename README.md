# Coverage Reporter
Prints out the code coverage and exits with an error if the code coverage is below the threshold.

The coverage is determined by a clover coverage report that can be generate by PHPUnit, just by adding the ```--coverage-clover``` option.

## Installation
```sh
composer require noregression/coverage-reportor
```

## Usage
```sh
bin/ci coverage:report /tmp/clover.xml -m 90
```

Replace ```/tmp/clover.xml``` with the path to your clover coverage report.

```-m 90``` means the minimum code coverage must be 90%.
