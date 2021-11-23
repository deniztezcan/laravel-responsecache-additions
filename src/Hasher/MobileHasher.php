<?php

namespace DenizTezcan\ResponseCache\Hasher;

use Spatie\ResponseCache\Hasher\DefaultHasher;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;

class MobileHasher extends DefaultHasher
{
	public function getHashFor(Request $request): string
    {
    	$cacheNamePrefix = $this->getCacheNamePrefix();
        $cacheNameSuffix = $this->getCacheNameSuffix($request);

        return 'responsecache-' . md5(
            "$cacheNamePrefix-{$request->getHost()}-{$request->getRequestUri()}-{$request->getMethod()}/$cacheNameSuffix"
        );
    }

    protected function getCacheNamePrefix()
    {
        $agent = new Agent();
        return ($agent->isMobile() ? "MOB" : "DSK");
    }
}