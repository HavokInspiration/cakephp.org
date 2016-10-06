<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\I18n;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

	protected $availableLanguages = [
		'en' => 'en',
		'ja_JP' => 'jp',
		'fr_FR' => 'fr',
	];

	/**
	 * Initialization hook method.
	 *
	 * Use this method to add common initialization code like loading components.
	 *
	 * e.g. `$this->loadComponent('Security');`
	 *
	 * @return void
	 */
	public function initialize()
	{
		parent::initialize();

		$this->loadComponent('RequestHandler');
		$this->loadComponent('Flash');
		$this->loadComponent('Security');
		$this->loadComponent('Csrf');
		$this->loadComponent('CakeDC/Users.UsersAuth');
	}

	public function beforeFilter(Event $event)
	{
		$this->setLocale();
		return parent::beforeFilter($event);
	}

	/**
	 * Sets the current locale based on url param and available languages
	 *
	 * @return void
	 */
	protected function setLocale()
	{
		$selectedLanguage = 'en';
		$lang = $this->request->param('language');

		if ($lang && isset($this->availableLanguages[$lang])) {
			I18n::locale($lang);
			$selectedLanguage = $this->availableLanguages[$lang];
		}

		$this->set('selectedLanguage', $selectedLanguage);
		$this->set('availableLanguages', $this->availableLanguages);
	}

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
        $this->set([
            '_version' => Configure::read('App.version'),
        ]);
    }
}
