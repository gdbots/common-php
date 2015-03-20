# CHANGELOG for 0.x
This changelog references the relevant changes done in 0.x versions.


## v0.1.1
* [GeneratesIdentifier], [Identifier] Return `static` on phpdoc for better IDE support.
* bug [StringIdentifier], [UuidIdentifier] Equals method to use `==` instead of comparing strings as those don't taken into account different types/classes.
* Adds [SlugUtils], [HashtagUtils], [SlugIdentifier] and [DatedSlugIdentifier].
* Set all Util classes to final and disabled constructor as these should not be extended or instantiated.


## v0.1.0
* Initial version.
