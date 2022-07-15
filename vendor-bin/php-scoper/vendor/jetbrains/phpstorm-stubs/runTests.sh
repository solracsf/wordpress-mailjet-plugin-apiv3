#!/usr/bin/env bash
echo "Installing composer packages..."
docker-compose -f docker-compose.yml run test_runner composer install -d /opt/project/phpstorm-stubs --ignore-platform-reqs
phpVersions=("7.1" "7.2" "7.3" "7.4" "8.0" "8.1")
for i in "${phpVersions[@]}"
do
  export PHP_VERSION=$i
  SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"
  cd "$SCRIPT_DIR" || exit
  echo "Building docker container for PHP_$i..."
  docker-compose -f docker-compose.yml build
  echo "Dumping reflection data to file $SCRIPT_DIR/ReflectionData.json for PHP_$i..."
  docker-compose -f docker-compose.yml run -e PHP_VERSION="$i" php_under_test /usr/local/bin/php /opt/project/phpstorm-stubs/tests/Tools/dump-reflection-to-file.php ReflectionData.json
  echo "Running tests agains PHP_$i..."
  docker-compose -f docker-compose.yml run -e PHP_VERSION="$i" test_runner /opt/project/phpstorm-stubs/vendor/bin/phpunit --configuration /opt/project/phpstorm-stubs/phpunit.xml --testsuite PHP_"$i"
  echo "Removing file $SCRIPT_DIR/ReflectionData.json with reflection data for PHP_$i..."
  rm -f "$SCRIPT_DIR/ReflectionData.json"
done
