<?php

class __Mustache_6aa824286b5d04e544c63f18c3cc253f extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="container-fluid">
';
        $buffer .= $indent . '    <div class="row mb-2">
';
        $buffer .= $indent . '        <div class="col">';
        // 'str' section
        $value = $context->find('str');
        $buffer .= $this->sectionB677bb4603c97e8a2898c4f6f74731de($context, $indent, $value);
        $buffer .= '</div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '<form method="post" action="editbulkcompletion.php" class="mform" id="theform">
';
        $buffer .= $indent . '    <div class="row mb-2">
';
        $buffer .= $indent . '        <div class="col">
';
        $buffer .= $indent . '            <input type="submit" value="';
        // 'str' section
        $value = $context->find('str');
        $buffer .= $this->sectionAd3b4bf865abc6ce6b96cc2301a00c9b($context, $indent, $value);
        $buffer .= '" class="btn btn-primary" name="submitbutton" aria-label="';
        // 'str' section
        $value = $context->find('str');
        $buffer .= $this->section46ed94fc67d37db95d2c79bd289ec008($context, $indent, $value);
        $buffer .= '" disabled/>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '    <div class="row mb-1">
';
        $buffer .= $indent . '        <div class="col-xs-6">
';
        $buffer .= $indent . '            <input type="checkbox" class="mastercheck mr-1" aria-label="';
        // 'str' section
        $value = $context->find('str');
        $buffer .= $this->sectionE60299a98d737e5927b8b3cbb25b5973($context, $indent, $value);
        $buffer .= '">
';
        $buffer .= $indent . '            <label class="font-weight-bold">';
        // 'str' section
        $value = $context->find('str');
        $buffer .= $this->section0ec703e4b4acc6dde3c5dbe2a45a0068($context, $indent, $value);
        $buffer .= '</label>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '        <div class="col-xs-6">
';
        $buffer .= $indent . '            <label class="font-weight-bold">';
        // 'str' section
        $value = $context->find('str');
        $buffer .= $this->section9722c348cbabcd3c31bb23e79176c20b($context, $indent, $value);
        $buffer .= '</label>
';
        $buffer .= $indent . '            <span>';
        $value = $this->resolveValue($context->find('helpicon'), $context);
        $buffer .= $value;
        $buffer .= '</span>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '    <hr class="row">
';
        $buffer .= $indent . '    <div class="topics">
';
        // 'sections' section
        $value = $context->find('sections');
        $buffer .= $this->section56f12382735d60c7879e1015b0e812ab($context, $indent, $value);
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '    <input type="hidden" name="id" value="';
        $value = $this->resolveValue($context->find('courseid'), $context);
        $buffer .= call_user_func($this->mustache->getEscape(), $value);
        $buffer .= '" />
';
        $buffer .= $indent . '    <input type="hidden" name="sesskey" value="';
        $value = $this->resolveValue($context->find('sesskey'), $context);
        $buffer .= call_user_func($this->mustache->getEscape(), $value);
        $buffer .= '" />
';
        $buffer .= $indent . '    <div class="row">
';
        $buffer .= $indent . '        <div class="col">
';
        $buffer .= $indent . '            <input type="submit" value="';
        // 'str' section
        $value = $context->find('str');
        $buffer .= $this->sectionAd3b4bf865abc6ce6b96cc2301a00c9b($context, $indent, $value);
        $buffer .= '" class="btn btn-primary" name="submitbutton" disabled/>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</form>
';
        $buffer .= $indent . '</div>
';
        $buffer .= $indent . '
';
        // 'js' section
        $value = $context->find('js');
        $buffer .= $this->sectionB407656e7c16008b967bfac3458049af($context, $indent, $value);

        return $buffer;
    }

    private function sectionB677bb4603c97e8a2898c4f6f74731de(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'bulkactivitydetail, core_completion';
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
                
                $buffer .= 'bulkactivitydetail, core_completion';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionAd3b4bf865abc6ce6b96cc2301a00c9b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'edit';
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
                
                $buffer .= 'edit';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section46ed94fc67d37db95d2c79bd289ec008(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'updateactivities, completion';
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
                
                $buffer .= 'updateactivities, completion';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE60299a98d737e5927b8b3cbb25b5973(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'checkall, completion';
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
                
                $buffer .= 'checkall, completion';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section0ec703e4b4acc6dde3c5dbe2a45a0068(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'activitieslabel, core_completion';
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
                
                $buffer .= 'activitieslabel, core_completion';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section9722c348cbabcd3c31bb23e79176c20b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'completion, core_completion';
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
                
                $buffer .= 'completion, core_completion';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF2110c85bc87f15a5f5dd36afe329d42(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'checkallsection, completion, {{{name}}}';
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
                
                $buffer .= 'checkallsection, completion, ';
                $value = $this->resolveValue($context->find('name'), $context);
                $buffer .= $value;
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section56f12382735d60c7879e1015b0e812ab(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                <div class="mb-1">
                    <div class="row mb-1 row-fluid">
                        <div class="col-sm-12">
                            <input type="checkbox" data-section-master="{{sectionnumber}}" class="mr-1" aria-label="{{#str}}checkallsection, completion, {{{name}}}{{/str}}">
                            <h3 class="d-inline-block">{{{name}}}</h3>
                        </div>
                    </div>
                    {{> core_course/activityinstance}}
                </div>
                <hr class="row">
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
                
                $buffer .= $indent . '                <div class="mb-1">
';
                $buffer .= $indent . '                    <div class="row mb-1 row-fluid">
';
                $buffer .= $indent . '                        <div class="col-sm-12">
';
                $buffer .= $indent . '                            <input type="checkbox" data-section-master="';
                $value = $this->resolveValue($context->find('sectionnumber'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '" class="mr-1" aria-label="';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->sectionF2110c85bc87f15a5f5dd36afe329d42($context, $indent, $value);
                $buffer .= '">
';
                $buffer .= $indent . '                            <h3 class="d-inline-block">';
                $value = $this->resolveValue($context->find('name'), $context);
                $buffer .= $value;
                $buffer .= '</h3>
';
                $buffer .= $indent . '                        </div>
';
                $buffer .= $indent . '                    </div>
';
                if ($partial = $this->mustache->loadPartial('core_course/activityinstance')) {
                    $buffer .= $partial->renderInternal($context, $indent . '                    ');
                }
                $buffer .= $indent . '                </div>
';
                $buffer .= $indent . '                <hr class="row">
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionB407656e7c16008b967bfac3458049af(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
require([
    \'jquery\',
], function($) {
    $(\'.mastercheck\').click(function() {
        var checked = $(\'.mastercheck\').is(\':checked\');
        $(\'input[type=checkbox]\').each(function() {
            $(this).prop(\'checked\', checked);
            $(this).trigger(\'change\'); // Hmmm. Could be smarter about this and only trigger once for the first checkbox.
        });
    });
    var mastersection = $(\'input[data-section-master]\');
    mastersection.click(function() {
        var checked = $(this).is(\':checked\');
        var dataid = $(this).attr(\'data-section-master\');
        $(\'input[type=checkbox][data-section=\\\'\' + dataid + \'\\\']\').each(function() {
            $(this).prop(\'checked\', checked);
            $(this).trigger(\'change\'); // Hmmm. Could be smarter about this and only trigger once for the first checkbox.
        });
    });

    $(\'input[type=checkbox][id^=selectactivity_]\').change(function() {
        if ($(this).is(\':checked\')) {
            $(\'[name=submitbutton]\').removeAttr(\'disabled\');
        } else {
            // Is this the last activity checkbox to be un-checked? If so, disable the edit button.
            var somechecked = false;
            $(\'input[type=checkbox][id^=selectactivity_]\').each(function() {
                if ($(this).is(\':checked\')) {
                    somechecked = true;
                    return false;
                }
                return true;
            });
            if (!somechecked) {
                $(\'[name=submitbutton]\').attr(\'disabled\', \'disabled\');
            }
        }
    });
});
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
                
                $buffer .= $indent . 'require([
';
                $buffer .= $indent . '    \'jquery\',
';
                $buffer .= $indent . '], function($) {
';
                $buffer .= $indent . '    $(\'.mastercheck\').click(function() {
';
                $buffer .= $indent . '        var checked = $(\'.mastercheck\').is(\':checked\');
';
                $buffer .= $indent . '        $(\'input[type=checkbox]\').each(function() {
';
                $buffer .= $indent . '            $(this).prop(\'checked\', checked);
';
                $buffer .= $indent . '            $(this).trigger(\'change\'); // Hmmm. Could be smarter about this and only trigger once for the first checkbox.
';
                $buffer .= $indent . '        });
';
                $buffer .= $indent . '    });
';
                $buffer .= $indent . '    var mastersection = $(\'input[data-section-master]\');
';
                $buffer .= $indent . '    mastersection.click(function() {
';
                $buffer .= $indent . '        var checked = $(this).is(\':checked\');
';
                $buffer .= $indent . '        var dataid = $(this).attr(\'data-section-master\');
';
                $buffer .= $indent . '        $(\'input[type=checkbox][data-section=\\\'\' + dataid + \'\\\']\').each(function() {
';
                $buffer .= $indent . '            $(this).prop(\'checked\', checked);
';
                $buffer .= $indent . '            $(this).trigger(\'change\'); // Hmmm. Could be smarter about this and only trigger once for the first checkbox.
';
                $buffer .= $indent . '        });
';
                $buffer .= $indent . '    });
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '    $(\'input[type=checkbox][id^=selectactivity_]\').change(function() {
';
                $buffer .= $indent . '        if ($(this).is(\':checked\')) {
';
                $buffer .= $indent . '            $(\'[name=submitbutton]\').removeAttr(\'disabled\');
';
                $buffer .= $indent . '        } else {
';
                $buffer .= $indent . '            // Is this the last activity checkbox to be un-checked? If so, disable the edit button.
';
                $buffer .= $indent . '            var somechecked = false;
';
                $buffer .= $indent . '            $(\'input[type=checkbox][id^=selectactivity_]\').each(function() {
';
                $buffer .= $indent . '                if ($(this).is(\':checked\')) {
';
                $buffer .= $indent . '                    somechecked = true;
';
                $buffer .= $indent . '                    return false;
';
                $buffer .= $indent . '                }
';
                $buffer .= $indent . '                return true;
';
                $buffer .= $indent . '            });
';
                $buffer .= $indent . '            if (!somechecked) {
';
                $buffer .= $indent . '                $(\'[name=submitbutton]\').attr(\'disabled\', \'disabled\');
';
                $buffer .= $indent . '            }
';
                $buffer .= $indent . '        }
';
                $buffer .= $indent . '    });
';
                $buffer .= $indent . '});
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
