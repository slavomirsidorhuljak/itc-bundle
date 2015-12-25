<?php

/**
 * SK ITCBundle Abstract Command
 *
 * @licence GNU GPL
 *
 * @author Slavomir Kuzma <slavomir.kuzma@gmail.com>
 */
namespace SK\ITCBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use Monolog\Logger;

abstract class TableCommand extends ContainerAwareCommand
{

	/**
	 *
	 * @var array
	 */
	protected $header;

	/**
	 *
	 * @var array
	 */
	protected $rows;

	/**
	 * Constructs SK ITCBundle Abstract Command
	 *
	 * @param string $name
	 *        	SK ITCBundle Abstract Command Name
	 * @param string $description
	 *        	SK ITCBundle Abstract Command Description
	 * @param Logger $logger
	 *        	SK ITCBundle Abstract Command Logger
	 */
	public function __construct(
		$name,
		$description,
		Logger $logger )
	{

		parent::__construct( $name );
		$this->setDescription( $description );
		$this->setLogger( $logger );

	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see \Symfony\Component\Console\Command\Command::execute()
	 */
	public function execute(
		InputInterface $input,
		OutputInterface $output )
	{

		$this->setInput( $input );
		$this->setOutput( $output );

	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see \Symfony\Component\Console\Command\Command::configure()
	 */
	protected function configure()
	{

		parent::configure();

	}

	/**
	 * Gets SK ITCBundle Abstract Command Input
	 *
	 * @return InputInterface
	 */
	public function getInput()
	{

		return $this->input;

	}

	/**
	 * Sets SK ITCBundle Abstract Command Input
	 *
	 * @param InputInterface $input
	 */
	public function setInput(
		InputInterface $input )
	{

		$this->input = $input;
		return $this;

	}

	/**
	 * Gets SK ITCBundle Abstract Command Output
	 *
	 * @return OutputInterface
	 */
	public function getOutput()
	{

		return $this->output;

	}

	/**
	 * Sets SK ITCBundle Abstract Command Output
	 *
	 * @param OutputInterface $output
	 */
	public function setOutput(
		OutputInterface $output )
	{

		$this->output = $output;
		return $this;

	}

	/**
	 * Gets SK ITCBundle Abstract Command Exception
	 *
	 * @return \Exception[]
	 */
	public function getExceptions()
	{

		if( null == $this->exceptions )
		{
			$this->exceptions = array();
		}
		return $this->exceptions;

	}

	/**
	 * Sets SK ITCBundle Abstract Command Exception
	 *
	 * @param \Exception[] $exceptions
	 *        	SK ITCBundle Abstract Command Exceptions
	 * @return \SK\ITCBundle\Command\Code\CodeCommand SK ITCBundle Abstract Command
	 */
	public function setExceptions(
		array $exceptions )
	{

		$this->exceptions = $exceptions;
		return $this;

	}

	/**
	 * Adds SK ITCBundle Abstract Command Exception
	 *
	 * @param \Exception $exception
	 *        	SK ITCBundle Abstract Command Exception
	 * @return \SK\ITCBundle\Command\Code\CodeCommand
	 */
	public function addException(
		\Exception $exception )
	{

		$this->exceptions[] = $exception;
		return $this;

	}

	/**
	 * Writes SK ITCBundle Abstract Command Exception
	 *
	 * @param \Exception $exception
	 *        	SK ITCBundle Abstract Command Exception
	 * @return \SK\ITCBundle\Command\AbstractCommand SK ITCBundle Abstract Command
	 */
	public function writeException(
		\Exception $exception )
	{

		$this->getOutput()
			->writeln(
			sprintf( " <fg=black;bg=red>Error %s %s</fg=black;bg=red>", $exception->getCode(), $exception->getMessage() ),
			OutputInterface::VERBOSITY_VERBOSE );

		$this->getOutput()
			->writeln(
			sprintf( " <fg=black;bg=red>Trace %s</fg=black;bg=red>", $exception->getTraceAsString() ),
			OutputInterface::VERBOSITY_VERY_VERBOSE );

	}

	/**
	 * Writes SK ITCBundle Abstract Command Exceptions
	 *
	 * @return \SK\ITCBundle\Command\AbstractCommand SK ITCBundle Abstract Command
	 */
	public function writeExceptions()
	{

		if( count( $this->getExceptions() ) > 0 )
		{
			$this->writeInfo( "Occured %d exceptions", count( $this->getExceptions() ) );
			foreach( $this->getExceptions() as $exception )
			{
				$this->writeException( $exception );
			}
		}
		return $this;

	}

	/**
	 * Writes SK ITCBundle Abstract Command Line
	 *
	 * @param string $message
	 *        	SK ITCBundle Abstract Command Info Line
	 * @return \SK\ITCBundle\Command\AbstractCommand SK ITCBundle Abstract Command
	 */
	public function writeLine(
		$message = "\n",
		$verbosity = OutputInterface::VERBOSITY_NORMAL )
	{

		$this->getOutput()
			->writeln( $message );
		return $this;

	}

	/**
	 * Writes SK ITCBundle Abstract Command Info
	 *
	 * @param string $message
	 *        	SK ITCBundle Abstract Command Info Message
	 * @return \SK\ITCBundle\Command\AbstractCommand SK ITCBundle Abstract Command
	 */
	public function writeInfo(
		$message,
		$verbosity = OutputInterface::VERBOSITY_NORMAL )
	{

		$output = $this->getOutput();
		$output->writeln( sprintf( '<bg=green>%s</bg=green>', $message ), $verbosity );
		return $this;

	}

	/**
	 * Writes SK ITCBundle Abstract Command Header
	 *
	 * @param string $message
	 *        	SK ITCBundle Abstract Command Header Message
	 * @return \SK\ITCBundle\Command\AbstractCommand SK ITCBundle Abstract Command
	 */
	public function writeHeader(
		$message )
	{

		$output = $this->getOutput();
		$output->writeln( ' <fg=white;bg=magenta>' . $message . "</fg=white;bg=magenta>" );
		return $this;

	}

	/**
	 * Writes SK ITCBundle Abstract Command Table
	 *
	 * @param array $rows
	 *        	SK ITCBundle Abstract Command Table Rows
	 * @param array $header
	 *        	SK ITCBundle Abstract Command Table Header
	 * @return \SK\ITCBundle\Command\AbstractCommand SK ITCBundle Abstract Command
	 */
	public function writeTable(
		$rows = array(),
		$header = array(),
		$verbosity = OutputInterface::VERBOSITY_NORMAL,
		$maxColWidth = 60 )
	{

		foreach( $rows as $iRow => $row )
		{
			foreach( $row as $iCol => $col )
			{
				$rows[ $iRow ][ $iCol ] = wordwrap( $col, $maxColWidth, "\n", true );
			}
		}
		$table = new Table( $this->getOutput() );
		$table->setHeaders( $header );
		$table->setRows( $rows );
		$table->render();
		return $this;

	}

	/**
	 * Writes SK ITCBundle Abstract Command Notice
	 *
	 * @param string $message
	 *        	SK ITCBundle Abstract Command Notice Message
	 * @return \SK\ITCBundle\Command\AbstractCommand SK ITCBundle Abstract Command
	 */
	public function writeNotice(
		$message,
		$verbosity = OutputInterface::VERBOSITY_NORMAL )
	{

		$this->getOutput()
			->writeln( "<fg=yellow>{$message}</fg=yellow>", $verbosity );
		return $this;

	}

	/**
	 * Writes SK ITCBundle Abstract Command Debug
	 *
	 * @param string $message
	 *        	SK ITCBundle Abstract Command Debug Message
	 * @return \SK\ITCBundle\Command\AbstractCommand SK ITCBundle Abstract Command
	 */
	public function writeDebug(
		$message )
	{

		$input = $this->getInput();
		$output = $this->getOutput();

		if( self::OPTION_VERBOSE_OUTPUT_YES == $input->getOption( "verbose" ) )
		{
			$output->writeln( ' <fg=blue;bg=white>DEBUG:</fg=blue;bg=white> ' . $message );
		}
		return $this;

	}

	/**
	 * Gets SK ITCBundle Abstract Command Logger
	 *
	 * @return Logger SK ITCBundle Abstract Command Logger
	 */
	public function getLogger()
	{

		return $this->logger;

	}

	/**
	 * Sets SK ITCBundle Abstract Command Logger
	 *
	 * @param Logger $logger
	 *        	SK ITCBundle Abstract Command Logger
	 * @return \SK\ITCBundle\Command\AbstractCommand SK ITCBundle Abstract Command
	 */
	public function setLogger(
		Logger $logger )
	{

		$this->logger = $logger;

	}

	/**
	 *
	 * @return string
	 */
	public function getRootDir()
	{

		if( NULL === $this->rootDir )
		{
			$this->setRootDir( getcwd() );
		}

		return $this->rootDir;

	}

	public function setRootDir(
		$rootDir )
	{

		$this->rootDir = $rootDir;
		return $this;

	}

}