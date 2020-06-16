<?php

class __Mustache_10dd9353aac1d5b94c00b31b758109c4 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '
';
        // 'hasstrings' inverted section
        $value = $context->find('hasstrings');
        if (empty($value)) {
            
            $buffer .= $indent . '    ';
            $value = $this->resolveValue($context->find('nostrings'), $context);
            $buffer .= $value;
            $buffer .= '
';
        }
        // 'hasstrings' section
        $value = $context->find('hasstrings');
        $buffer .= $this->section9c7082afeab11bd69e7e4ee913d9b07c($context, $indent, $value);

        return $buffer;
    }

    private function section9c3f383e742e0076ba43b0782ab18655(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'savecontinue, tool_customlang';
            $result = call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda((string) $result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'savecontinue, tool_customlang';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE3af6584ee6f55bc20c163c14a30d8a3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'savecheckin, tool_customlang';
            $result = call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda((string) $result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'savecheckin, tool_customlang';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionA0a7a7a5f371da3b4a4b62fded8c7336(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'headingcomponent, tool_customlang';
            $result = call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda((string) $result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'headingcomponent, tool_customlang';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section786d1ad51a00cbbf97599d18e4ac1d1b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'headingstringid, tool_customlang';
            $result = call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda((string) $result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'headingstringid, tool_customlang';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionAf4fb7fcfe9679c26779d38bc01fa8bf(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'headingstandard, tool_customlang';
            $result = call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda((string) $result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'headingstandard, tool_customlang';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section59a339a1d9f3a5518873897e9e4098e1(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'headinglocal, tool_customlang';
            $result = call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda((string) $result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'headinglocal, tool_customlang';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC37fd3c209faba1215d50a2b7cec7348(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'list-group-item-info';
            $result = call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda((string) $result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'list-group-item-info';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section4b91ad2f89a25afe640d05e4c2c8c75b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'list-group-item-warning';
            $result = call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda((string) $result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'list-group-item-warning';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionAdfd8096c0f3f658a3a45be0cd39d499(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                    <div class="alert-secondary mt-3 mt-1">
                        {{ original }}
                    </div>
                    ';
            $result = call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda((string) $result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                    <div class="alert-secondary mt-3 mt-1">
';
                $buffer .= $indent . '                        ';
                $value = $this->resolveValue($context->find('original'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '
';
                $buffer .= $indent . '                    </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section21f57dc1931af0dc22359202f183a071(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'markuptodate, tool_customlang';
            $result = call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda((string) $result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'markuptodate, tool_customlang';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionA2f6667ca3bc9c8460609ebe4266e231(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                        <div class="uptodatewrapper">
                            <div class="form-check">
                                <input id="update_{{id}}" class="form-check-input" name="updates[]" type="checkbox" value="{{id}}">
                                <label for="update_{{id}}" class="form-check-label">{{#str}}markuptodate, tool_customlang{{/str}}</label>
                                {{{ outdatedhelp }}}
                            </div>
                        </div>
                        ';
            $result = call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda((string) $result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                        <div class="uptodatewrapper">
';
                $buffer .= $indent . '                            <div class="form-check">
';
                $buffer .= $indent . '                                <input id="update_';
                $value = $this->resolveValue($context->find('id'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '" class="form-check-input" name="updates[]" type="checkbox" value="';
                $value = $this->resolveValue($context->find('id'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '">
';
                $buffer .= $indent . '                                <label for="update_';
                $value = $this->resolveValue($context->find('id'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '" class="form-check-label">';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->section21f57dc1931af0dc22359202f183a071($context, $indent, $value);
                $buffer .= '</label>
';
                $buffer .= $indent . '                                ';
                $value = $this->resolveValue($context->find('outdatedhelp'), $context);
                $buffer .= $value;
                $buffer .= '
';
                $buffer .= $indent . '                            </div>
';
                $buffer .= $indent . '                        </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section7ea6122c2c434e978cf296ad03406c9f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <div class="container-fluid list-group-item
                {{#local}}list-group-item-info{{/local}}
                {{#outdated}}list-group-item-warning{{/outdated}}
                {{#modified}}list-group-item-info{{/modified}}"
            >
            <div class="row-fluid ">
                <div class="col-sm-4 col-md-2">
                    <div class="d-md-none">
                        <strong>{{#str}}headingcomponent, tool_customlang{{/str}}</strong>
                    </div>
                    {{{ component }}}
                </div>
                <div class="col-sm-4 col-md-2 text-break">
                    <div class="d-md-none">
                        <strong>{{#str}}headingstringid, tool_customlang{{/str}}</strong>
                    </div>
                    {{{ stringid }}}
                </div>
                <div class="col-sm-4 col-md-2">
                    <div class="d-md-none">
                        <strong>{{#str}}headingstandard, tool_customlang{{/str}}</strong>
                    </div>
                    {{ master }}
                    <div class="info">
                        {{{ placeholderhelp }}}
                        {{{ outdatedhelp}}}
                    </div>
                    {{#showoriginalvsmaster}}
                    <div class="alert-secondary mt-3 mt-1">
                        {{ original }}
                    </div>
                    {{/showoriginalvsmaster}}
                </div>
                <div class="col-sm-12 col-md-6 mt-sm-3 mt-md-0">
                    <div class="d-md-none">
                        <strong>{{#str}}headinglocal, tool_customlang{{/str}}</strong>
                    </div>
                    <div class="py-2 py-md-0 px-md-3">
                        <textarea class="form-control w-100 border-box" name="cust[{{id}}]" cols="40" rows="3">{{{ local }}}</textarea>

                        {{#checkupdated}}
                        <div class="uptodatewrapper">
                            <div class="form-check">
                                <input id="update_{{id}}" class="form-check-input" name="updates[]" type="checkbox" value="{{id}}">
                                <label for="update_{{id}}" class="form-check-label">{{#str}}markuptodate, tool_customlang{{/str}}</label>
                                {{{ outdatedhelp }}}
                            </div>
                        </div>
                        {{/checkupdated}}
                    </div>
                </div>
            </div>
        </div>
    ';
            $result = call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda((string) $result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        <div class="container-fluid list-group-item
';
                $buffer .= $indent . '                ';
                // 'local' section
                $value = $context->find('local');
                $buffer .= $this->sectionC37fd3c209faba1215d50a2b7cec7348($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '                ';
                // 'outdated' section
                $value = $context->find('outdated');
                $buffer .= $this->section4b91ad2f89a25afe640d05e4c2c8c75b($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '                ';
                // 'modified' section
                $value = $context->find('modified');
                $buffer .= $this->sectionC37fd3c209faba1215d50a2b7cec7348($context, $indent, $value);
                $buffer .= '"
';
                $buffer .= $indent . '            >
';
                $buffer .= $indent . '            <div class="row-fluid ">
';
                $buffer .= $indent . '                <div class="col-sm-4 col-md-2">
';
                $buffer .= $indent . '                    <div class="d-md-none">
';
                $buffer .= $indent . '                        <strong>';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->sectionA0a7a7a5f371da3b4a4b62fded8c7336($context, $indent, $value);
                $buffer .= '</strong>
';
                $buffer .= $indent . '                    </div>
';
                $buffer .= $indent . '                    ';
                $value = $this->resolveValue($context->find('component'), $context);
                $buffer .= $value;
                $buffer .= '
';
                $buffer .= $indent . '                </div>
';
                $buffer .= $indent . '                <div class="col-sm-4 col-md-2 text-break">
';
                $buffer .= $indent . '                    <div class="d-md-none">
';
                $buffer .= $indent . '                        <strong>';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->section786d1ad51a00cbbf97599d18e4ac1d1b($context, $indent, $value);
                $buffer .= '</strong>
';
                $buffer .= $indent . '                    </div>
';
                $buffer .= $indent . '                    ';
                $value = $this->resolveValue($context->find('stringid'), $context);
                $buffer .= $value;
                $buffer .= '
';
                $buffer .= $indent . '                </div>
';
                $buffer .= $indent . '                <div class="col-sm-4 col-md-2">
';
                $buffer .= $indent . '                    <div class="d-md-none">
';
                $buffer .= $indent . '                        <strong>';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->sectionAf4fb7fcfe9679c26779d38bc01fa8bf($context, $indent, $value);
                $buffer .= '</strong>
';
                $buffer .= $indent . '                    </div>
';
                $buffer .= $indent . '                    ';
                $value = $this->resolveValue($context->find('master'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '
';
                $buffer .= $indent . '                    <div class="info">
';
                $buffer .= $indent . '                        ';
                $value = $this->resolveValue($context->find('placeholderhelp'), $context);
                $buffer .= $value;
                $buffer .= '
';
                $buffer .= $indent . '                        ';
                $value = $this->resolveValue($context->find('outdatedhelp'), $context);
                $buffer .= $value;
                $buffer .= '
';
                $buffer .= $indent . '                    </div>
';
                // 'showoriginalvsmaster' section
                $value = $context->find('showoriginalvsmaster');
                $buffer .= $this->sectionAdfd8096c0f3f658a3a45be0cd39d499($context, $indent, $value);
                $buffer .= $indent . '                </div>
';
                $buffer .= $indent . '                <div class="col-sm-12 col-md-6 mt-sm-3 mt-md-0">
';
                $buffer .= $indent . '                    <div class="d-md-none">
';
                $buffer .= $indent . '                        <strong>';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->section59a339a1d9f3a5518873897e9e4098e1($context, $indent, $value);
                $buffer .= '</strong>
';
                $buffer .= $indent . '                    </div>
';
                $buffer .= $indent . '                    <div class="py-2 py-md-0 px-md-3">
';
                $buffer .= $indent . '                        <textarea class="form-control w-100 border-box" name="cust[';
                $value = $this->resolveValue($context->find('id'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= ']" cols="40" rows="3">';
                $value = $this->resolveValue($context->find('local'), $context);
                $buffer .= $value;
                $buffer .= '</textarea>
';
                $buffer .= $indent . '
';
                // 'checkupdated' section
                $value = $context->find('checkupdated');
                $buffer .= $this->sectionA2f6667ca3bc9c8460609ebe4266e231($context, $indent, $value);
                $buffer .= $indent . '                    </div>
';
                $buffer .= $indent . '                </div>
';
                $buffer .= $indent . '            </div>
';
                $buffer .= $indent . '        </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section9c7082afeab11bd69e7e4ee913d9b07c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
<form method="post" action="{{{formurl}}}">
    <input type="hidden" name="translatorsubmitted" value="1">
    <input type="hidden" name="sesskey" value="{{{ sesskey }}}">
    <input type="hidden" name="p" value="{{ currentpage }}">

    <fieldset class="m-a-1 m-3">
        <button type="submit" name="savecontinue" class="btn btn-secondary">
            {{#str}}savecontinue, tool_customlang{{/str}}
        </button>
        <button type="submit" name="savecheckin" class="btn btn-secondary">
            {{#str}}savecheckin, tool_customlang{{/str}}
        </button>
    </fieldset>

    <div class="list-group">
        <div class="container-fluid d-none d-md-block list-group-item border-bottom-0">
            <div class="row-fluid">
                <div class="col-sm-4 col-md-2">
                    <strong>{{#str}}headingcomponent, tool_customlang{{/str}}</strong>
                </div>
                <div class="col-sm-4 col-md-2">
                    <strong>{{#str}}headingstringid, tool_customlang{{/str}}</strong>
                </div>
                <div class="col-sm-4 col-md-2">
                    <strong>{{#str}}headingstandard, tool_customlang{{/str}}</strong>
                </div>
                <div class="col-sm-12 col-md-6">
                    <span class="p-l-1 pl-3">
                        <strong>{{#str}}headinglocal, tool_customlang{{/str}}</strong>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="list-group">
    {{#strings}}
        <div class="container-fluid list-group-item
                {{#local}}list-group-item-info{{/local}}
                {{#outdated}}list-group-item-warning{{/outdated}}
                {{#modified}}list-group-item-info{{/modified}}"
            >
            <div class="row-fluid ">
                <div class="col-sm-4 col-md-2">
                    <div class="d-md-none">
                        <strong>{{#str}}headingcomponent, tool_customlang{{/str}}</strong>
                    </div>
                    {{{ component }}}
                </div>
                <div class="col-sm-4 col-md-2 text-break">
                    <div class="d-md-none">
                        <strong>{{#str}}headingstringid, tool_customlang{{/str}}</strong>
                    </div>
                    {{{ stringid }}}
                </div>
                <div class="col-sm-4 col-md-2">
                    <div class="d-md-none">
                        <strong>{{#str}}headingstandard, tool_customlang{{/str}}</strong>
                    </div>
                    {{ master }}
                    <div class="info">
                        {{{ placeholderhelp }}}
                        {{{ outdatedhelp}}}
                    </div>
                    {{#showoriginalvsmaster}}
                    <div class="alert-secondary mt-3 mt-1">
                        {{ original }}
                    </div>
                    {{/showoriginalvsmaster}}
                </div>
                <div class="col-sm-12 col-md-6 mt-sm-3 mt-md-0">
                    <div class="d-md-none">
                        <strong>{{#str}}headinglocal, tool_customlang{{/str}}</strong>
                    </div>
                    <div class="py-2 py-md-0 px-md-3">
                        <textarea class="form-control w-100 border-box" name="cust[{{id}}]" cols="40" rows="3">{{{ local }}}</textarea>

                        {{#checkupdated}}
                        <div class="uptodatewrapper">
                            <div class="form-check">
                                <input id="update_{{id}}" class="form-check-input" name="updates[]" type="checkbox" value="{{id}}">
                                <label for="update_{{id}}" class="form-check-label">{{#str}}markuptodate, tool_customlang{{/str}}</label>
                                {{{ outdatedhelp }}}
                            </div>
                        </div>
                        {{/checkupdated}}
                    </div>
                </div>
            </div>
        </div>
    {{/strings}}
    </div>

    <fieldset class="m-a-1 m-3">
        <button type="submit" name="savecontinue" class="btn btn-secondary">
            {{#str}}savecontinue, tool_customlang{{/str}}
        </button>
        <button type="submit" name="savecheckin" class="btn btn-secondary">
            {{#str}}savecheckin, tool_customlang{{/str}}
        </button>
    </fieldset>
</form>
';
            $result = call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda((string) $result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '<form method="post" action="';
                $value = $this->resolveValue($context->find('formurl'), $context);
                $buffer .= $value;
                $buffer .= '">
';
                $buffer .= $indent . '    <input type="hidden" name="translatorsubmitted" value="1">
';
                $buffer .= $indent . '    <input type="hidden" name="sesskey" value="';
                $value = $this->resolveValue($context->find('sesskey'), $context);
                $buffer .= $value;
                $buffer .= '">
';
                $buffer .= $indent . '    <input type="hidden" name="p" value="';
                $value = $this->resolveValue($context->find('currentpage'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '">
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '    <fieldset class="m-a-1 m-3">
';
                $buffer .= $indent . '        <button type="submit" name="savecontinue" class="btn btn-secondary">
';
                $buffer .= $indent . '            ';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->section9c3f383e742e0076ba43b0782ab18655($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '        </button>
';
                $buffer .= $indent . '        <button type="submit" name="savecheckin" class="btn btn-secondary">
';
                $buffer .= $indent . '            ';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->sectionE3af6584ee6f55bc20c163c14a30d8a3($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '        </button>
';
                $buffer .= $indent . '    </fieldset>
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '    <div class="list-group">
';
                $buffer .= $indent . '        <div class="container-fluid d-none d-md-block list-group-item border-bottom-0">
';
                $buffer .= $indent . '            <div class="row-fluid">
';
                $buffer .= $indent . '                <div class="col-sm-4 col-md-2">
';
                $buffer .= $indent . '                    <strong>';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->sectionA0a7a7a5f371da3b4a4b62fded8c7336($context, $indent, $value);
                $buffer .= '</strong>
';
                $buffer .= $indent . '                </div>
';
                $buffer .= $indent . '                <div class="col-sm-4 col-md-2">
';
                $buffer .= $indent . '                    <strong>';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->section786d1ad51a00cbbf97599d18e4ac1d1b($context, $indent, $value);
                $buffer .= '</strong>
';
                $buffer .= $indent . '                </div>
';
                $buffer .= $indent . '                <div class="col-sm-4 col-md-2">
';
                $buffer .= $indent . '                    <strong>';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->sectionAf4fb7fcfe9679c26779d38bc01fa8bf($context, $indent, $value);
                $buffer .= '</strong>
';
                $buffer .= $indent . '                </div>
';
                $buffer .= $indent . '                <div class="col-sm-12 col-md-6">
';
                $buffer .= $indent . '                    <span class="p-l-1 pl-3">
';
                $buffer .= $indent . '                        <strong>';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->section59a339a1d9f3a5518873897e9e4098e1($context, $indent, $value);
                $buffer .= '</strong>
';
                $buffer .= $indent . '                    </span>
';
                $buffer .= $indent . '                </div>
';
                $buffer .= $indent . '            </div>
';
                $buffer .= $indent . '        </div>
';
                $buffer .= $indent . '    </div>
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '    <div class="list-group">
';
                // 'strings' section
                $value = $context->find('strings');
                $buffer .= $this->section7ea6122c2c434e978cf296ad03406c9f($context, $indent, $value);
                $buffer .= $indent . '    </div>
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '    <fieldset class="m-a-1 m-3">
';
                $buffer .= $indent . '        <button type="submit" name="savecontinue" class="btn btn-secondary">
';
                $buffer .= $indent . '            ';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->section9c3f383e742e0076ba43b0782ab18655($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '        </button>
';
                $buffer .= $indent . '        <button type="submit" name="savecheckin" class="btn btn-secondary">
';
                $buffer .= $indent . '            ';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->sectionE3af6584ee6f55bc20c163c14a30d8a3($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '        </button>
';
                $buffer .= $indent . '    </fieldset>
';
                $buffer .= $indent . '</form>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
