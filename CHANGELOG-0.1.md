CHANGELOG for 0.1.x
===================

This changelog references the relevant changes (bug and security fixes) done in 0.1 minor versions.

* 0.1.1 (2015-03-??)

 * [GeneratesIdentifier] Return `static` on phpdoc for better IDE support. (gdbrown)
 * [Identifier] Return `static` on phpdoc for better IDE support. (gdbrown)
 * bug [StringIdentifier], [UuidIdentifier] Equals method to use `==` instead of comparing strings as those don't taken into account different types/classes. (gdbrown)
