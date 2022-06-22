<?php

namespace App\Components\Translator;

use App\Model\TranslationManager;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class TranslatorControl extends Control {
    private $output = '';
    /** @var TranslationManager */
    private $translator;

    public function __construct(TranslationManager $translator) {
        $this->translator = $translator;
    }

    public function render(): void {
        $this->template->output = $this->output;
        $this->template->render(__DIR__ . '/translator.latte');
    }

    protected function createComponentTranslatorForm(): Form {
        $form = new Form;

        $form->addTextArea('text', 'Text:')
            ->setRequired('Field Text is required.')
            ->addRule(Form::MIN_LENGTH, 'Text must be at least %d char.', 1);

        $form->addSubmit('submit', 'Translate');
        $form->onSuccess[] = [$this, 'translatorFormSucceeded'];

        return $form;
    }

    public function translatorFormSucceeded(\stdClass $data): void {
        $this->output = $this->translator->translate($data->text);
        if ($this->presenter->isAjax()) {
            $this->redrawControl('output');
        } else {
            $this->presenter->redirect('this');
        }
    }

}

interface TranslatorControlFactory {

    public function create(): TranslatorControl;
}
