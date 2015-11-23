# CHANGELOG for 0.x
This changelog references the relevant changes done in 0.x versions.


## v0.1.6
* BUG: Do not use v0.1.5.  Scrutinr recommended fix (unused argument on Enum) created fatal error.


## v0.1.5
* [Microtime] Ensure `toDateTime` returns a DateTime object in UTC regardless of php config. (BUG


## v0.1.4
* Added `toSnakeFromSlug` and `toSlugFromSnake` to [StringUtils].
* Using psr4 to load `src` and `tests` now.


## v0.1.3
* [HashtagUtils] Fix bug where generated hashtag might contain invalid chars.


## v0.1.2
* Rename composer package to `gdbots/common`.


## v0.1.1
* [GeneratesIdentifier], [Identifier] Return `static` on phpdoc for better IDE support.
* bug [StringIdentifier], [UuidIdentifier] Equals method to use `==` instead of comparing strings as those don't taken into account different types/classes.
* Adds [SlugUtils], [HashtagUtils], [SlugIdentifier] and [DatedSlugIdentifier].
* Set all Util classes to final and disabled constructor as these should not be extended or instantiated.


## v0.1.0
* Initial version.
