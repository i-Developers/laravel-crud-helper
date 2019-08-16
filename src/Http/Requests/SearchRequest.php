<?php
declare(strict_types=1);

namespace Technote\CrudHelper\Http\Requests;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Technote\CrudHelper\Models\Contracts\Crudable;
use Technote\CrudHelper\Providers\Contracts\ModelInjectionable;
use Technote\SearchHelper\Models\Contracts\Searchable;

/**
 * Class SearchRequest
 * @package Technote\CrudHelper\Http\Requests
 */
class SearchRequest extends FormRequest implements ModelInjectionable
{
    /** @var string|Eloquent|Crudable $target */
    private $target;

    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @param  string  $target
     */
    public function setTarget(string $target)
    {
        $this->target = $target;
    }

    /**
     * @return Model|Searchable
     * @SuppressWarnings(PHPMD.MissingImport)
     */
    private function getInstance()
    {
        return new $this->target;
    }

    /**
     * @return string
     */
    private function getPerPage()
    {
        return $this->target::getPerPageName();
    }

    /**
     * @return array
     */
    protected function getDefaultRules()
    {
        return array_merge([
            's'      => 'nullable|string',
            'count'  => 'nullable|integer|min:0',
            'offset' => 'nullable|integer|min:0',
        ], [
            $this->getPerPage() => 'nullable|integer|min:1',
        ]);
    }

    /**
     * @return array
     */
    protected function getDefaultAttributes()
    {
        return array_merge([
            's'      => trans('technote::validation.attributes.s'),
            'count'  => trans('technote::validation.attributes.count'),
            'offset' => trans('technote::validation.attributes.offset'),
        ], [
            $this->getPerPage() => trans('technote::validation.attributes.per_page'),
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        if (is_subclass_of($this->target, Searchable::class)) {
            return array_merge($this->getDefaultRules(), $this->getInstance()->getSearchRules());
        }

        return [
            $this->getPerPage() => 'nullable|integer|min:1',
        ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        if (is_subclass_of($this->target, Searchable::class)) {
            return array_merge($this->getDefaultAttributes(), $this->getInstance()->getSearchAttributes());
        }

        return [
            $this->getPerPage() => trans('technote::validation.attributes.per_page'),
        ];
    }

    /**
     * @return array
     */
    public function getConditions()
    {
        return $this->validated();
    }
}