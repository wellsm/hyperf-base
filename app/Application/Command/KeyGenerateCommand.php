<?php

declare(strict_types=1);

namespace Application\Command;

use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Command\Annotation\Command;
use Symfony\Component\Console\Input\InputOption;

use function Hyperf\Support\env;

#[Command(name: 'key:generate', description: 'Generate Application Key', options: [
    [self::OPTION_SHOW, 's', InputOption::VALUE_NONE, 'Display the key instead of modifying files'],
    [self::OPTION_FORCE, 'f', InputOption::VALUE_NONE, 'Force the operation to run overwriting the key'],
])]
class KeyGenerateCommand extends HyperfCommand
{
    private const OPTION_SHOW  = 'show';
    private const OPTION_FORCE = 'force';

    public function handle()
    {
        $key = $this->generateRandomKey();

        if ($this->option(self::OPTION_SHOW)) {
            return $this->line("<comment>{$key}</comment>");
        }

        $updated = $this->setKeyInEnvironmentFile($key);

        if ($updated === false) {
            return;
        }

        $this->info('Application key set successfully.');
    }

    private function generateRandomKey(): string
    {
        return 'base64:'. base64_encode(random_bytes(32));
    }

    private function setKeyInEnvironmentFile(string $key): bool
    {
        $currentKey = env('APP_KEY') ?? '';
        $force      = $this->option(self::OPTION_FORCE);

        if (strlen($currentKey) !== 0 && $force === false) {
            return false;
        }

        return $this->writeNewEnvironmentFileWith($key);
    }

    protected function writeNewEnvironmentFileWith(string $key): bool
    {
        $envPath  = BASE_PATH . '/.env';
        $input    = file_get_contents($envPath);
        $replaced = preg_replace(
            pattern: $this->keyReplacementPattern(),
            replacement: "APP_KEY={$key}",
            subject: $input
        );

        if ($replaced === $input || $replaced === null) {
            $this->error('Unable to set application key. No APP_KEY variable was found in the .env file.');

            return false;
        }

        file_put_contents($envPath, $replaced);

        return true;
    }

    protected function keyReplacementPattern(): string
    {
        $key     = env('APP_KEY');
        $escaped = preg_quote("={$key}", '/');

        return "/^APP_KEY{$escaped}/m";
    }
}
