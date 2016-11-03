<?php
use Cake\Core\Configure;
?>
<?= $this->element('meta', [
    'title' => __("Terms of Service")
]);?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li>
                    <?= $this->Html->link(__("Home"), '/') ?>
                </li>
                <li class="active">
                    <?= __("Terms") ?>
                </li>
            </ol>
            <?= $this->Flash->render() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <section class="terms section">
                <div class="hr-divider">
                    <h3 class="hr-divider-content hr-divider-heading">
                        <?= __('Terms of Service') ?>
                    </h3>
                </div>
                <p class="updated">
                    <?= __('Last update : {0}', ucwords((new \Cake\I18n\Time('11/03/2016'))->i18nFormat([\IntlDateFormatter::LONG, \IntlDateFormatter::NONE]))) ?>
                </p>

                <div class="space-10"></div>

                <h4 id="summary">
                    <?= $this->Html->link('<i class="fa fa-link"></i>', '#summary', ['escape' => false]) ?>
                    <?= __('Summary') ?>
                </h4>
                <ol>
                    <li>
                        <h5>
                            <?= $this->Html->link(__('General Information'), '#general-information') ?>
                        </h5>
                    </li>
                    <li>
                        <h5>
                            <?= $this->Html->link(__('Account Terms'), '#account-terms') ?>
                        </h5>
                    </li>
                    <li>
                        <h5>
                            <?= $this->Html->link(__('Copyright and Content Ownership'), '#copyright-and-content-ownership') ?>
                        </h5>
                    </li>
                    <li>
                        <h5>
                            <?= $this->Html->link(__('General Conditions'), '#general-conditions') ?>
                        </h5>
                    </li>
                    <li>
                        <h5>
                            <?= $this->Html->link(__('Privacy Policy Terms'), '#privacy-policy-terms') ?>
                        </h5>

                        <ol>
                            <li>
                                <h5>
                                    <?= $this->Html->link(__('Cookies'), '#privacy-policy-terms_cookies') ?>
                                </h5>
                            </li>
                            <li>
                                <h5>
                                    <?= $this->Html->link(__('Data Storage'), '#privacy-policy-terms_data-storage') ?>
                                </h5>
                            </li>
                            <li>
                                <h5>
                                    <?= $this->Html->link(__('Information Gathering and Usage'), '#privacy-policy-terms_information-gathering-and-usage') ?>
                                </h5>
                            </li>
                        </ol>
                    </li>
                </ol>

                <div class="space-10"></div>

                <h4 id="general-information">
                    <?= $this->Html->link('<i class="fa fa-link"></i>', '#general-information', ['escape' => false]) ?>
                    <?= __('General Information') ?>
                </h4>
                <p>
                    <?= __('Violation of any of the terms below will result in the termination of your Account. While {0} prohibits such conduct and Content on the Service, you understand and agree that {0} cannot be responsible for the Content posted on the Service and you nonetheless may be exposed to such materials. You agree to use the Service at your own risk.',
                    Configure::read('Site.name')) ?>
                </p>

                <div class="space-20"></div>

                <h4 id="account-terms">
                    <?= $this->Html->link('<i class="fa fa-link"></i>', '#account-terms', ['escape' => false]) ?>
                    <?= __('Account Terms') ?>
                </h4>
                <ol>
                    <li>
                        <?= __('You must be 13 years or older to use this Service.') ?>
                    </li>
                    <li>
                        <?= __('You must provide your username, a valid email address, and any other information requested in order to complete the signup process.') ?>
                    </li>
                    <li>
                        <?= __('You are responsible for maintaining the security of your account and password. {0} cannot and will not be liable for any loss or damage from your failure to comply with this security obligation.', Configure::read('Site.name')) ?>
                    </li>
                    <li>
                        <?= __('You are responsible for all Content posted and activity that occurs under your Account.') ?>
                    </li>
                    <li>
                        <?= __('Selling your Account is totally prohibited and will result in the termination of your Account.') ?>
                    </li>
                    <li>
                        <?= __('It is totally prohibited to share your Account with an other user. In that case, the Account shared will be immediately banned and you will lose all purchases made from your Account.') ?>
                    </li>
                    <li>
                        <?= __('One person or legal entity may not maintain more than one Account.') ?>
                    </li>
                    <li>
                        <?= __('When deleting your Account, all your Content will not be deleted directly. If you want all your Content to be deleted, please ask {0}.', $this->Html->link(__('here'), ['controller' => 'contact', 'action' => 'index'])) ?>
                    </li>
                </ol>

                <div class="space-20"></div>

                <h4 id="copyright-and-content-ownership">
                    <?= $this->Html->link('<i class="fa fa-link"></i>', '#copyright-and-content-ownership', ['escape' => false]) ?>
                    <?= __('Copyright and Content Ownership') ?>
                </h4>
                <ol>
                    <li>
                        <?= __('The look and feel of the Service is copyright &copy;{0} {1}. All rights reserved. You may not duplicate, copy, or reuse any portion of the HTML/CSS, Javascript, or visual design elements or concepts without express written permission from {1}.', date('Y', time()), Configure::read('Site.name')) ?>
                    </li>
                    <li>
                        <?= __('All trademarks, service marks, trade names, trade dress, product names and logos appearing on the site are the property of their respective owners.') ?>
                    </li>
                </ol>

                <div class="space-20"></div>

                <h4 id="general-conditions">
                    <?= $this->Html->link('<i class="fa fa-link"></i>', '#general-conditions', ['escape' => false]) ?>
                    <?= __('General Conditions') ?>
                </h4>
                <ol>
                    <li>
                        <?= __('Your use of the Service is at your sole risk. The service is provided on an "as is" and "as available" basis.') ?>
                    </li>
                    <li>
                        <?= __('You understand that {0} uses third-party vendors and hosting partners to provide the necessary hardware, software, networking, storage, and related technology required to run the Service.', Configure::read('Site.name')) ?>
                    </li>
                    <li>
                        <?= __('You must not modify, adapt or hack the Service or modify another website so as to falsely imply that it is associated with the Service, {0}, or any other {0} service.', Configure::read('Site.name')) ?>
                    </li>
                    <li>
                        <?= __('You agree not to reproduce, duplicate, copy, sell, resell or exploit any portion of the Service, use of the Service, or access to the Service without the express written permission by {0}.', Configure::read('Site.name')) ?>
                    </li>
                    <li>
                        <?= __('We may, but have no obligation to, remove Content and Accounts containing Content that we determine in our sole discretion are unlawful, offensive, threatening, libelous, defamatory, pornographic, obscene or otherwise objectionable or violates any party\'s intellectual property or these Terms of Service.') ?>
                    </li>
                    <li>
                        <?= __('Verbal, physical, written or other abuse (including threats of abuse or retribution) of any {0} customer, members, or staff will result in immediate account termination.', Configure::read('Site.name')) ?>
                    </li>
                    <li>
                        <?= __('You understand that the technical processing and transmission of the Service, including your Content, may be transferred unencrypted.') ?>
                    </li>
                    <li>
                        <?= __('Questions about the Terms of Service should be sent to {0}.', $this->Html->link(Configure::read('Site.contact_email'), 'mailto:' . Configure::read('Site.contact_email'))) ?>
                    </li>
                </ol>

                <div class="space-20"></div>

                <h4 id="privacy-policy-terms">
                    <?= $this->Html->link('<i class="fa fa-link"></i>', '#privacy-policy-terms', ['escape' => false]) ?>
                    <?= __('Privacy Policy Terms') ?>
                </h4>
                <ol>
                    <li>
                        <h5 id="privacy-policy-terms_cookies">
                            <?= $this->Html->link('<i class="fa fa-link"></i>', '#privacy-policy-terms_cookies', ['escape' => false]) ?>
                            <?= __('Cookies') ?>
                        </h5>

                        <ol>
                            <li>
                                <?= __('A cookie is a small amount of data, which often includes an anonymous unique identifier, that is sent to your browser from a web site\'s computers and stored on your computer\'s hard drive.') ?>
                            </li>
                            <li>
                                <?= __('Cookies are required to use the {0} service.', Configure::read('Site.name')) ?>
                            </li>
                            <li>
                                <?= __('We use cookies to record current session information, but do not use permanent cookies. You are required to re-login to your {0} account after a certain period of time has elapsed to protect you against others accidentally accessing your account contents.', Configure::read('Site.name')) ?>
                            </li>
                        </ol>
                    </li>
                    <li>
                        <h5 id="privacy-policy-terms_data-storage">
                            <?= $this->Html->link('<i class="fa fa-link"></i>', '#privacy-policy-terms_data-storage', ['escape' => false]) ?>
                            <?= __('Data Storage') ?>
                        </h5>

                        <ol>
                            <li>
                                <?= __('{0} uses third-party vendors and hosting partners to provide the necessary hardware, software, networking, storage, and related technology required to run {0}. Although {0} owns the code, databases, and all rights to the {0} application, you retain all rights to your data.', Configure::read('Site.name')) ?>
                            </li>
                        </ol>
                    </li>
                    <li>
                        <h5 id="privacy-policy-terms_information-gathering-and-usage">
                            <?= $this->Html->link('<i class="fa fa-link"></i>', '#privacy-policy-terms_information-gathering-and-usage', ['escape' => false]) ?>
                            <?= __('Information Gathering and Usage') ?>
                        </h5>

                        <ol>
                            <li>
                                <?= __('{0} uses collected information for the following general purposes: products and services payments, billing, identification and authentication, services improvement, contact, and research.', Configure::read('Site.name')) ?>
                            </li>
                        </ol>
                    </li>
                </ol>
            </section>
        </div>
    </div>
</div>
