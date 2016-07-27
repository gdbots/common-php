# CHANGELOG for 1.x
This changelog references the relevant changes done in 1.x versions.


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
