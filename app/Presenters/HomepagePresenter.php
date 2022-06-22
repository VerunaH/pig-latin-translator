<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Components\Translator\TranslatorControl;
use App\Components\Translator\TranslatorControlFactory;
use Nette;

final class HomepagePresenter extends Nette\Application\UI\Presenter {

    /** @var TranslatorControlFactory */
    private $translatorForm;

    public function __construct(TranslatorControlFactory $translatorForm) {
        $this->translatorForm = $translatorForm;
    }

    protected function createComponentTranslatorForm(): TranslatorControl {
        $control = $this->translatorForm->create();
        return $control;
    }

}
