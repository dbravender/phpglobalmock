# GlobalMock for PHP #

## Purpose ##

GlobalMock allows you to test and refactor code that calls global
functions that have side effects by simulating their behavior without
actually running them.

## Background ##

It can be very difficult to test and therefore refactor PHP that
uses global functions that rely on side-effects. For example, if your
application calls mysql_query it can be hard to refactor and test the
code without resetting the state of the database before running the test
each time. Many languages allow you to redifine functions, so writing mock
object libraries is easy. Unfortunately PHP expressly forbids redefining
functions. There are some solutions but they require 3rd party modules
and are self-admitted hacks.

## How to test your code ##

Before running global functions run `$gm =
GlobalMock::getInstance();`. Then prepend all calls to global functions
with `$gm->function_name()`. You can see an example of an original program
and a testable version in the example folder.
