<?php

namespace CodeColliders\BasicUserBundle\Maker;

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputAwareMakerInterface;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class BasicUserInitMaker extends AbstractMaker
{
    protected static $defaultName = 'basic-user:init';
    protected $projectDir;
    protected static $POSITIVE_ANSWERS = ['y','yes','o', 'oui'];

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator): int
    {
        $io = new SymfonyStyle($input, $io);
        $userClass = $input->getOption('user-class');
        if($userClass){
            $userClassNameDetails = $generator->createClassNameDetails(
                $userClass,
                'Entity\\'
            );
            $userPath = $generator->generateClass(
                $userClassNameDetails->getFullName(),
                __DIR__.'/../Resources/skeleton/user.tpl.php'
            );
            $generator->writeChanges();
            $userClassNameDetails = $userClassNameDetails->getFullName();
            $io->text("The class '$userClassNameDetails' has been created");
        } else {
            $userClassNameDetails = $io->ask('Choose your User class <fg=yellow>[App\\Entity\\User]</>')??'App\\Entity\\User';
            $userIdentifier = $io->ask('Which field is the unique identifier for your user <fg=yellow>[email]</>')??'email';
        }
        $route_prefix = $io->ask('Choose a prefix refix for routes \'/login\' and \'/logout\' <fg=yellow>[/user]</>')??'/user';
        $redirect_route = $io->ask('Choose a route to redirect after login <fg=yellow>[code_colliders_basic_user_login]</>')??'code_colliders_basic_user_login';
        $branding = in_array(mb_strtolower($io->ask('Configure form branding (<fg=yellow>y/N</>)')),self::$POSITIVE_ANSWERS)?[]:false;
        if($branding === []){
            $branding["form_title"] = $io->ask('Form title <fg=yellow>[Log in]</>')??'Log in';
            $branding["catchphrase"] = $io->ask('Form catchphrase <fg=yellow>[Using basic user bundle]</>')??'Using basic user bundle';
            $branding["logo_url"] = $io->ask('Your logo URL <fg=yellow>[null]</>')??'null';
            $branding["background_url"] = $io->ask('Form background image URL <fg=yellow>[null]</>')??'null';
        }
        $generator->generateFile($this->projectDir.'/config/packages/code_colliders_basic_user.yaml', __DIR__.'/../Resources/skeleton/config.tpl.php', [
            "user_class"=>$userClassNameDetails,
            "user_identifier"=>$userIdentifier,
            "redirect_route"=>$redirect_route,
            "branding"=>$branding,
        ]);
        $generator->generateFile($this->projectDir.'/config/routes/code_colliders_basic_user.yaml', __DIR__.'/../Resources/skeleton/routes.tpl.php', [
            "route_prefix"=>$route_prefix
        ]);
        $generator->writeChanges();

        $io->success("Configuration successfully created. Now, you can generate a password using 'security:encode-password' and login at '$route_prefix/login'");

        return 0;
    }

    /**
     * @inheritDoc
     */
    public static function getCommandName(): string
    {
        return self::$defaultName;
    }

    /**
     * @inheritDoc
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command->setDescription('Inintialize the basic user bundle')
            ->setHelp('This command create configuration and entity for basic user bundle')
//            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('user-class', 'c', InputOption::VALUE_REQUIRED, 'Create a user class for authentication')
        ;
    }

    /**
     * @inheritDoc
     */
    public function configureDependencies(DependencyBuilder $dependencies)
    {
    }
}
