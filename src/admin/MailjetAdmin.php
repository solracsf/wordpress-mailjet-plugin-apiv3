<?php

namespace MailjetWp\MailjetPlugin\Admin;

use MailjetWp\MailjetPlugin\Includes\Mailjeti18n;/**
 * The admin-specific functionality of the plugin.
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 * @package    Mailjet
 * @subpackage Mailjet/admin
 * @author     Your Name <email@example.com>
 */
class MailjetAdmin
{
    /**
     * The ID of this plugin.
     *
     * @since    5.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;
    /**
     * The version of this plugin.
     *
     * @since    5.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;
    /**
     * Initialize the class and set its properties.
     *
     * @since    5.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }
    /**
     * Register the stylesheets for the admin area.
     *
     * @since    5.0.0
     */
    public function enqueue_styles()
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Plugin_Name_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Plugin_Name_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/mailjet-admin.css', array(), $this->version, 'all');
    }
    /**
     * Register the JavaScript for the admin area.
     *
     * @since    5.0.0
     */
    public function enqueue_scripts()
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Plugin_Name_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Plugin_Name_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/mailjet-admin.js', array('jquery'), $this->version, \false);
    }

    /**
     * @return void
     */
    public function mailjetPluginNotification(): void
    {
        if (function_exists('get_current_screen')) {
            $currentScreen = get_current_screen();
            if ($currentScreen &&
                ($currentScreen->id === 'dashboard' ||
                    $currentScreen->id === 'admin_page_mailjet_dashboard_page' ||
                    $currentScreen->id === 'admin_page_mailjet_connect_account_page'
                )
            ) {
                echo sprintf('<div class="notice notice-warning"><p>%s</p></div>', $this->getWarningTranslation(Mailjeti18n::getLocale()));
            }
        }
    }

    /**
     * @param string $locale
     * @return string
     */
    private function getWarningTranslation(string $locale): string
    {
        switch ($locale) {
            case 'en_US':
                return 'Mailjet\'s Subscription Widget is on its way out, but a new way to integrate your forms is coming shortly. Stay tuned!';
            case 'fr_FR':
                return 'Le widget d\'inscription de Mailjet tire bientôt sa révérence, mais une nouvelle méthode d\'intégration des formulaires va prendre sa relève. Restez à l\'écoute!';
            case 'de_DE':
                return 'Das Abonnement-Widget von Mailjet wird nicht mehr weiterentwickelt, aber eine neue Möglichkeit zur Integration Ihrer Formulare kommt in Kürze. Wir halten Sie auf dem Laufenden.';
            case 'es_ES':
                return 'El Widget de suscripción de Mailjet está a punto de despedirse, así que tendrás formas nuevas de integrar tus formularios. No te las pierdas.';
            case 'it_IT':
                return 'Il widget di iscrizione di Mailjet è in fase di dismissione, ma è in arrivo un nuovo modo per integrare i moduli. Non perderti gli aggiornamenti!';
            default:
                return 'Mailjet\'s Subscription Widget is on its way out, but a new way to integrate your forms is coming shortly. Stay tuned!';
        }
    }
}
