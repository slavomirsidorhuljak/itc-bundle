<?php
/**
 * SK ITC Bundle Application Console Kernel
 *
 * @author Slavomir Kuzma <slavomir.kuzma@gmail.com>
 */
namespace SK\ITCBundle\Application;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Bundle\AsseticBundle\AsseticBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;
use JMS\SerializerBundle\JMSSerializerBundle;
use SK\ITCBundle\SKITCBundle;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle;
use Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle;

class SocketKernel extends Kernel
{

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Symfony\Component\HttpKernel\KernelInterface::registerBundles()
	 */
	public function registerBundles()
	{
		$bundles = array(
			new SecurityBundle(),
			new DoctrineBundle(),
			new MonologBundle(),
			new TwigBundle(),
			new SwiftmailerBundle(),
			new AsseticBundle(),
			new SensioFrameworkExtraBundle(),
			new JMSSerializerBundle(),
			new SKITCBundle()
		);

		if( in_array( $this->getEnvironment(), array(
			'dev',
			'test'
		), true ) )
		{
			$bundles[] = new SensioGeneratorBundle();
		}
		return $bundles;
	}

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Symfony\Component\HttpKernel\Kernel::getRootDir()
	 */
	public function getRootDir()
	{
		return __DIR__ . '/../../../..';
	}

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Symfony\Component\HttpKernel\Kernel::getCacheDir()
	 */
	public function getCacheDir()
	{
		return $this->getRootDir() . '/cache/' . $this->getEnvironment();
	}

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Symfony\Component\HttpKernel\Kernel::getLogDir()
	 */
	public function getLogDir()
	{
		return $this->getRootDir() . '/logs';
	}

	/**
	 *
	 * @param LoaderInterface $loader
	 */
	public function registerContainerConfiguration( LoaderInterface $loader )
	{
		$environment = $this->getEnvironment();
		$config = dirname( __DIR__ ) . sprintf( '/Resources/config/%s/config.xml', $environment );

		if( ! file_exists( $config ) )
		{
			$config = dirname( __DIR__ ) . sprintf( '/Resources/config/config.xml' );
		}

		if( file_exists( $config ) )
		{
			$loader->load( $config );
		}
	}
}