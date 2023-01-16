<?php

namespace App\Controllers;

// use Kenjis\CI4Twig\Twig;
use MatomoTracker;
use Kenjis\CI4Twig\Twig;
use CodeIgniter\Controller;
use Psr\Log\LoggerInterface;
use CodeIgniter\HTTP\CLIRequest;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    // public ?Twig $twig = null;
    public string $language = 'en';
    public ?User $user = null;
    public $parser = null;
    public static array $templateJavascripts = [];
    public static array $templateStylesheets = [];
    public array $languages = [];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        $this->helpers = array_merge($this->helpers, ['setting', 'form', 'auth', 'route', 'page','cookiepolicy', 'gettext']);

        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $response->setCache(['max-age' => '31536000']);	

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        
        // $this->twig = new Twig();

        $path = service('uri')->getPath();
        $chosenLanguage = substr($path, 0, 2);
        $supportedLocales = config('app')->supportedLocales;

        if (in_array($chosenLanguage, $supportedLocales)) {
            $request->setLocale($chosenLanguage);
        }
        
        $this->language = $request->getLocale();

        $this->languages = config('app')->languages;
        
        loadGettext($this->language);

        $this->user = auth()->user() ?? null;

        $animationsCookie = $request->getCookie('animations');
        if (empty($animationsCookie) or $animationsCookie == 'on') {
            $animationsEnabled = true;
        } else {
            $animationsEnabled = false;
        }

        $showCookiePolicyBanner = true;
        $privacyCookie = $request->getCookie('privacy');
        $cookiesConsent = $request->getCookie('cookiesConsent');

        if (!empty($privacyCookie)) {
            $showCookiePolicyBanner = false;
        }

        if (!empty($cookiesConsent)) {
            // dd($cookiesConsent);
        }

        $matomoSiteId = env('matomo.siteId');
        $matomoUrl = env('matomo.host');
        $matomoToken = env('matomo.token');
        $matomoPageTitle = '';

        $matomoTracker = new MatomoTracker($matomoSiteId, $matomoUrl);
        $matomoTracker->setTokenAuth($matomoToken);

        // TODO test gettext and publish website with pulling

        $view = service('renderer');
        $view->setVar('locale', $this->language);
        $view->setVar('templateJavascripts', static::$templateJavascripts);
        $view->setVar('templateStylesheets', static::$templateStylesheets);
        $view->setVar('isUserLogged', auth()->loggedIn());
        $view->setVar('authUser', auth()->user() ?? null);
        $view->setVar('animationsEnabled', $animationsEnabled);
        $view->setVar('languages', $this->languages);
        $view->setVar('showCookiePolicyBanner', $showCookiePolicyBanner);
        // $view->setVar('hasUserAcceptedTracking', $hasUserAcceptedTracking);

        // $this->parser = \Config\Services::parser();
        // $this->parser->setData([
        //     'locale' => $this->language,
        //     'templateJavascripts' => [],
        //     'templateStylesheets' => [],
        //     'isUserLogged' => auth()->loggedIn(),
        //     'authUser' => auth()->user() ?? null
        // ]);
    }
}
