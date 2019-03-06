# CHANGELOG for 1.x
This changelog references the relevant changes done in 1.x versions.


## v1.1.1
* Add `urlsafeB64Decode` and `urlsafeB64Encode` to `StringUtils`.


## v1.1.0
* Marked these classes as deprecated as they will be removed in 2.x.
  * BigNumber
  * GeoPoint
  * Microtime
  * Identifiers\*
* Moved `ext-bcmath`, `moontoast/math`, `ramsey/uuid` in `composer.json` to __require-dev__.  
  If you're not on `gdbots/pbj-php` 1.1.x or later you'll need to require these in your own project.


## v1.0.1
* Remove __final__ from classes in anticipation of moving to "WellKnown" types in `gdbots/pbj` library.
  * BigNumber
  * GeoPoint
  * Microtime
  * Identifiers\*


## v1.0.0
__BREAKING CHANGES__

* Requires php >=5.6.
* Uuid lib `rhumsaa/uuid` replaced with `ramsey/uuid`,same author, different package name.
* `Gdbots\Common\Util\DateUtils` now uses Zulu time format (the old IS08601 with offset will still validate).
* issue #5: Better ISO8601 format detection.
