<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bridge\Twig\Node;

use Symfony\Component\Form\FormRenderer;
use Twig\Compiler;
use Twig\Node\Node;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
class FormThemeNode extends Node
{
    public function __construct(Node $form, Node $resources, $lineno, $tag = null, $only = false)
    {
        parent::__construct(array('form' => $form, 'resources' => $resources), array('only' => (bool) $only), $lineno, $tag);
    }

    public function compile(Compiler $compiler)
    {
        $compiler
            ->addDebugInfo($this)
            ->write('$this->env->getRuntime(')
            ->string(FormRenderer::class)
            ->raw(')->setTheme(')
            ->subcompile($this->getNode('form'))
            ->raw(', ')
            ->subcompile($this->getNode('resources'))
            ->raw(', ')
            ->raw(false === $this->getAttribute('only') ? 'true' : 'false')
            ->raw(");\n");
    }
}
