# CHANGELOG for 0.x
This changelog references the relevant changes done in 0.x versions.


## v1.0.0
__BREAKING CHANGES__

* Requires php >=5.6.
* Uuid lib `rhumsaa/uuid` replaced with `ramsey/uuid`,same author, different package name.
* `Gdbots\Common\Util\DateUtils` now uses Zulu time format (the old IS08601 with offset will still validate).
