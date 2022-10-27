<?php namespace professionalweb\sendbox;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use professionalweb\sendbox\Services\SendboxAPI;
use professionalweb\sendbox\Services\AddressBook;
use professionalweb\sendbox\Services\SendboxProtocol;
use professionalweb\sendbox\Interfaces\Services\Protocol;
use professionalweb\sendbox\Interfaces\SendboxAPI as ISendboxAPI;
use professionalweb\sendbox\Interfaces\Services\AddressBook as IAddressBook;

class SendboxProvider extends ServiceProvider
{
    public function register(): void
    {
        parent::register();

        $this->app->singleton(ISendboxAPI::class, SendboxAPI::class);
        $this->app->singleton(IAddressBook::class, AddressBook::class);

        $this->app->singleton(Protocol::class, static function () {
            $result = new SendboxProtocol(config('services.sendbox.clientId', ''), config('services.sendbox.clientSecret', ''));
            $accessToken = Cache::get('sendbox-protocol-accessToken');
            if (!empty($accessToken)) {
                $result->setAccessToken($accessToken);
            }
        });
    }
}