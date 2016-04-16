<?php
/**
 * SK ITCBundle Command Mylyn Report Command
 *
 * @licence GNU GPL
 *
 * @author Slavomir Kuzma <slavomir.kuzma@gmail.com>
 */
namespace SK\ITCBundle\Command\OS;

use Symfony\Component\Console\Input\InputOption;
use SK\ITCBundle\OS\Command;
use SK\ITCBundle\Command\TableCommand;
use Symfony\Bridge\Monolog\Logger;

class ShellCommand extends TableCommand
{

	/**
	 *
	 * @var Command
	 */
	protected $command;

	/**
	 * Constructs SK ITCBundle Abstract Command
	 *
	 * @param string $name
	 * @param string $description
	 * @param Logger $logger
	 * @param Command $command
	 */
	public function __construct( $name, $description, Logger $logger, Command $command )
	{
		parent::__construct( $name, $description, $logger );

		$this->setCommand( $command );
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see \Symfony\Component\Console\Command\Command::configure()
	 */
	protected function configure()
	{
		parent::configure();

		$this->addOption( "command", "c", InputOption::VALUE_OPTIONAL, "Shell Command." );
		$this->addOption( "arguments", "a", InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, "Shell Command." );
	}

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \SK\ITCBundle\Command\TableCommand::getColumns()
	 */
	protected function getColumns()
	{
		return array();
	}

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \SK\ITCBundle\Command\TableCommand::getRows()
	 */
	protected function getRows()
	{
		if( null === $this->rows )
		{
			$this->setRows();
		}

		return $this->rows;
	}

	/**
	 *
	 * @return the Command
	 */
	protected function getCommand()
	{
		return $this->command;
	}

	/**
	 *
	 * @param Command $command
	 */
	protected function setCommand( Command $command )
	{
		$this->command = $command;
		return $this;
	}
}