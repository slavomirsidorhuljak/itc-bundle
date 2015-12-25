<?php
namespace SK\ITCBundle\Command\Code\Generator\DockBlock;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AllCommand extends AbstractCommand
{

	/**
	 * (non-PHPdoc)
	 *
	 * @see \SK\ITCBundle\Code\Generator\PHPUnit\AbstractGenerator::execute($input, $output)
	 */
	public function execute( InputInterface $input, OutputInterface $output )
	{
		parent::execute( $input, $output );

		$this->executeFileDockBlock( $input, $output );
		$this->executeClassDockBlock( $input, $output );
		$this->executeAttributeDockBlock( $input, $output );
		$this->executeOperationDockBlock( $input, $output );
	}
}