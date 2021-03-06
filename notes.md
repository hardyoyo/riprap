# Overview

To create a fixity auditing service for fcrepo-spec compliant repositories that produces reliable data on when a resource was validated and the outcome of that validation. The data collected can be used internally but the service but also outside the service by independent auditors.

# Schema

* event_id (autoincrement - system dependent?)
* event_uuid 
* event_type (verification, addition, update)
* resource_id uri
* datestamp  - should be timezoned
* hash_algorithm
* hash_value - we should allow null here because legacy events may not provdide a hash.
* event_outcome (success, failure, indeterminate) - there is (apprently) a PREMIS vocabulary for this, as mentioned during the PREMIS Implementers Fair at iPres 2018.

# Misc. Notes

* As per section 7 (Binary Resource Fixity) of the Fedora Specifiction, compliant repositories do not verify digests, they generate them and return them on request. So to validate a digest, the currently requested value needs to be compared to a reliable , previously generated digest.
* We want this service/the data generated by this service to be useful in evaluations based on the Digital Preservation Storage Criteria (https://osf.io/sjc6u/).
* Data will build up over time. We need a strategy for compressing/archiving/aggregating data and optionaly clearing out db tables and other storage mechanisms.


