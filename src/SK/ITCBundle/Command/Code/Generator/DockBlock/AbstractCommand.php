<?php
namespace SK\ITCBundle\Command\Code\Generator\DockBlock;

use SK\ITCBundle\Command\Code\Generator\GeneratorCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use SK\ITCBundle\Code\Generator\DocBlockGenerator;

/**
 *
 * @author jahman
 *
 */
class AbstractCommand extends GeneratorCommand
{

	/**
	 * (non-PHPdoc)
	 *
	 * @see \SK\ITCBundle\Code\Generator\PHPUnit\AbstractGenerator::execute($input, $output)
	 */
	public function executeOperationDockBlock( InputInterface $input, OutputInterface $output )
	{
		parent::execute( $input, $output );
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see \SK\ITCBundle\Code\Generator\PHPUnit\AbstractGenerator::execute($input, $output)
	 */
	public function executeAttributeDockBlock( InputInterface $input, OutputInterface $output )
	{
		parent::execute( $input, $output );
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see \SK\ITCBundle\Code\Generator\PHPUnit\AbstractGenerator::execute($input, $output)
	 */
	public function executeClassDockBlock( InputInterface $input, OutputInterface $output )
	{
		parent::execute( $input, $output );
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see \SK\ITCBundle\Code\Generator\PHPUnit\AbstractGenerator::execute($input, $output)
	 */
	public function executeFileDockBlock( InputInterface $input, OutputInterface $output )
	{
		parent::execute( $input, $output );

		$header = array(
			'File (s)',
			'Short Descriptions',
			'Author (s)',
			'Licence (s)',
		);

		$rows = [];

		foreach ($this->getFileRelections() as $reflection)
		{
			$row = array( $reflection->getPrettyName(),$reflection->getDocComment());
var_dump($reflection);
			$rows[] = $row;
			continue;
			if( $classReflection->getDocBlock() )
			{
				$classDocBlock = DocBlockGenerator::fromReflection( $classReflection->getDocBlock() );
			}
			else
			{
				$classDocBlock = new DocBlockGenerator( str_replace( "\\", " ", $classReflection->getName() ),
						"This Documentation is autogenerated by " . __CLASS__ );
			}
			$shortDescription = $classDocBlock->getShortDescription();


			$row = array(
				$classReflection->getNamespaceName(),
				$classReflection->getShortName(),
				$shortDescription
			);
			$tags = $classDocBlock->getTags();
			var_export( $tags );

			foreach( $tags as $tag )
			{

				$tagName = $tag->getName();
				$header[ $tagName ] = $tagName;
				$row[ $tagName ] = $tag->generate();
			}
		}

		$this->writeTable( $rows, $header );

	}
}