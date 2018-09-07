<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Sitemap\Command;

use MKebza\Sitemap\Service\SitemapRenderer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

class GenerateCommand extends Command
{
    /**
     * @var SitemapRenderer
     */
    private $sitemap;

    /**
     * @var string
     */
    private $defaultXmlFilePath;

    /**
     * GenerateCommand constructor.
     *
     * @param SitemapRenderer $sitemap
     */
    public function __construct(SitemapRenderer $sitemap, string $defaultXmlFilePath)
    {
        $this->sitemap = $sitemap;
        $this->defaultXmlFilePath = $defaultXmlFilePath;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('sitemap:generate')
            ->setDescription('Collect and generate sitemap')
            ->addArgument(
                'filename',
                InputArgument::OPTIONAL,
                'Where to output sitemap',
                $this->defaultXmlFilePath);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new SymfonyStyle($input, $output);

        $style->title('Generating sitemap');
        $style->writeln(sprintf('Output file: %s', $input->getArgument('filename')));

        $fs = new Filesystem();
        $fs->dumpFile($input->getArgument('filename'), $this->sitemap->render());

        $style->success('Sitemap exported');

        return 0;
    }
}
