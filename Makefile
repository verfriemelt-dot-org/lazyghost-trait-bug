function:
	bin/console ca:cl
	php -d opcache.jit=function bin/console ca:warm
	cat var/cache/qa/doctrine/orm/Proxies/__CG__sampleDomainEntityProvider.php

tracing:
	bin/console ca:cl
	php -d opcache.jit=tracing bin/console ca:warm
	cat var/cache/qa/doctrine/orm/Proxies/__CG__sampleDomainEntityProvider.php
