<?php
declare(strict_types=1);

namespace DachcomDigital\SocialData\Command;

use DachcomDigital\SocialData\Processor\FetchPostsProcessor;
use DachcomDigital\SocialData\Registry\ConnectorDefinitionRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FetchPostsCommand extends Command
{
    protected FetchPostsProcessor $fetchPostsProcessor;
    
    public function __construct(FetchPostsProcessor $fetchPostsProcessor)
    {
        $this->fetchPostsProcessor = $fetchPostsProcessor;
        parent::__construct();
    }
    
    protected function configure()
    {
        $this
            ->setName('social-data:fetch:posts')
            ->setDescription('Fetch posts')
            ->addOption('wallId', 'w', InputOption::VALUE_REQUIRED, 'Only perform fetch for specific wall');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->fetchPostsProcessor->process($input->getOption('wallId'));
        
        return 0;
    }
}
