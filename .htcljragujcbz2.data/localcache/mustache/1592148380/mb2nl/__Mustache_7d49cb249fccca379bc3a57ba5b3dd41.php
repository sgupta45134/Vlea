<?php

class __Mustache_7d49cb249fccca379bc3a57ba5b3dd41 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        // 'activities' section
        $value = $context->find('activities');
        $buffer .= $this->section43861bdcfb17f450b0679c2ccfbd4771($context, $indent, $value);

        return $buffer;
    }

    private function section85c6106adc0ba7b33c9045e748980c01(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'select, completion';
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
                
                $buffer .= 'select, completion';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section2c81f415962d0923c85914fee9b99c47(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'checkactivity, completion, {{{modname}}}';
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
                
                $buffer .= 'checkactivity, completion, ';
                $value = $this->resolveValue($context->find('modname'), $context);
                $buffer .= $value;
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section7632bcec29505f9635a36cef86378f0e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <label class="accesshide" for="selectactivity_{{cmid}}">{{#str}}select, completion{{/str}} {{modname}}</label>
            <input type="checkbox" id="selectactivity_{{cmid}}" class="mr-1" name="cmid[]" data-section="{{sectionnumber}}" value="{{cmid}}" aria-label="{{#str}}checkactivity, completion, {{{modname}}}{{/str}}">
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
                
                $buffer .= $indent . '            <label class="accesshide" for="selectactivity_';
                $value = $this->resolveValue($context->find('cmid'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '">';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->section85c6106adc0ba7b33c9045e748980c01($context, $indent, $value);
                $buffer .= ' ';
                $value = $this->resolveValue($context->find('modname'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '</label>
';
                $buffer .= $indent . '            <input type="checkbox" id="selectactivity_';
                $value = $this->resolveValue($context->find('cmid'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '" class="mr-1" name="cmid[]" data-section="';
                $value = $this->resolveValue($context->find('sectionnumber'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '" value="';
                $value = $this->resolveValue($context->find('cmid'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '" aria-label="';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->section2c81f415962d0923c85914fee9b99c47($context, $indent, $value);
                $buffer .= '">
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF01e2d3c0307b2bdf80d31dde5a980ad(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                {{{completionstatus.icon}}}
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
                
                $buffer .= $indent . '                ';
                $value = $this->resolveValue($context->findDot('completionstatus.icon'), $context);
                $buffer .= $value;
                $buffer .= '
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section43861bdcfb17f450b0679c2ccfbd4771(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
<div class="row mb-1 row-fluid">
    <div class="activityinstance col-xs-6">
        <div class="mod-indent-outer"></div>
        <div>
            {{#canmanage}}
            <label class="accesshide" for="selectactivity_{{cmid}}">{{#str}}select, completion{{/str}} {{modname}}</label>
            <input type="checkbox" id="selectactivity_{{cmid}}" class="mr-1" name="cmid[]" data-section="{{sectionnumber}}" value="{{cmid}}" aria-label="{{#str}}checkactivity, completion, {{{modname}}}{{/str}}">
            {{/canmanage}}
            <a href="{{url}}">
            <img src="{{icon}}" class="iconlarge activityicon" alt=" " role="presentation" />
            <span class="instancename">{{{modname}}}</span>
            </a>
        </div>
    </div>
    <div class="activity-completionstatus col-xs-6" id="completionstatus_{{cmid}}">
        <div class="col-sm-1  p-l-0">
            {{#completionstatus.icon}}
                {{{completionstatus.icon}}}
            {{/completionstatus.icon}}
            {{^completionstatus.icon}}
                <span class="mr-3"></span>
            {{/completionstatus.icon}}
        </div>
        <div class="col-sm-11  p-l-0">
            <span class="text-muted muted">{{{completionstatus.string}}}</span>
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
                
                $buffer .= $indent . '<div class="row mb-1 row-fluid">
';
                $buffer .= $indent . '    <div class="activityinstance col-xs-6">
';
                $buffer .= $indent . '        <div class="mod-indent-outer"></div>
';
                $buffer .= $indent . '        <div>
';
                // 'canmanage' section
                $value = $context->find('canmanage');
                $buffer .= $this->section7632bcec29505f9635a36cef86378f0e($context, $indent, $value);
                $buffer .= $indent . '            <a href="';
                $value = $this->resolveValue($context->find('url'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '">
';
                $buffer .= $indent . '            <img src="';
                $value = $this->resolveValue($context->find('icon'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '" class="iconlarge activityicon" alt=" " role="presentation" />
';
                $buffer .= $indent . '            <span class="instancename">';
                $value = $this->resolveValue($context->find('modname'), $context);
                $buffer .= $value;
                $buffer .= '</span>
';
                $buffer .= $indent . '            </a>
';
                $buffer .= $indent . '        </div>
';
                $buffer .= $indent . '    </div>
';
                $buffer .= $indent . '    <div class="activity-completionstatus col-xs-6" id="completionstatus_';
                $value = $this->resolveValue($context->find('cmid'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '">
';
                $buffer .= $indent . '        <div class="col-sm-1  p-l-0">
';
                // 'completionstatus.icon' section
                $value = $context->findDot('completionstatus.icon');
                $buffer .= $this->sectionF01e2d3c0307b2bdf80d31dde5a980ad($context, $indent, $value);
                // 'completionstatus.icon' inverted section
                $value = $context->findDot('completionstatus.icon');
                if (empty($value)) {
                    
                    $buffer .= $indent . '                <span class="mr-3"></span>
';
                }
                $buffer .= $indent . '        </div>
';
                $buffer .= $indent . '        <div class="col-sm-11  p-l-0">
';
                $buffer .= $indent . '            <span class="text-muted muted">';
                $value = $this->resolveValue($context->findDot('completionstatus.string'), $context);
                $buffer .= $value;
                $buffer .= '</span>
';
                $buffer .= $indent . '        </div>
';
                $buffer .= $indent . '    </div>
';
                $buffer .= $indent . '</div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
