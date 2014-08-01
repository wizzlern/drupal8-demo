#Demo Service#

This module provides:
- A Fubonacci service. A Fibonacci calculator to be loaded as a service, which
  makes it reusable for other modules.
- A Language manager service which overrides core's language.manager service. 
  The service sets the current language of user/1 to English.

This module is named 'service_demo' instead of 'demo_service' to make sure that
ServiceDemoServiceProvider::alter() is execute after the 
LanguageServiceProvider::alter(). The alter methods are executed in alphabetical
order. Alternatively the weight of the module could have been increased.
