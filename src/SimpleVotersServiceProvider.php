<?php
/**
 * @author Maksim Khodyrev<maximkou@gmail.com>
 * 12.05.17
 */

namespace Maximkou\SimpleVoters;

use Illuminate\Support\ServiceProvider;
use Maximkou\SimpleVoters\GrantStrategies\Affirmative;
use Maximkou\SimpleVoters\GrantStrategies\Consensus;
use Maximkou\SimpleVoters\GrantStrategies\Unanimous;
use Maximkou\SimpleVoters\Services\Access;

class SimpleVotersServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/voters.php' => config_path('voters.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/voters.php', 'voters'
        );

        $this->app->bind('simple_voters.strategies.unanimous', function ($app, $args) {
            return new Unanimous($args['voters']);
        });
        $this->app->bind('simple_voters.strategies.affirmative', function ($app, $args) {
            return new Affirmative($args['voters']);
        });
        $this->app->bind('simple_voters.strategies.consensus', function ($app, $args) {
            return new Consensus($args['voters']);
        });

        $this->app->singleton('simple_voters.checker', function ($app) {
            $strategy = $app['config']->get('voters.strategy', 'unanimous');
            $strategy = "simple_voters.strategies.$strategy";

            if (!isset($app[$strategy])) {
                throw new \Exception("Voting strategy service $strategy is not registered.");
            }

            return new Access($app->make($strategy, [
                'voters' => $this->prepareVoters($app['config']->get('voters.voters', []))
            ]));
        });
    }

    /**
     * @param array $classes
     * @return array
     */
    private function prepareVoters(array $classes)
    {
        return array_map(function ($class) {
            return $this->app->make($class);
        }, $classes);
    }
}