<?php

namespace Modules\Core\Models\Interfaces;

interface FilterableModel
{
    /**
     * Return the list of fields that are used to search in the table rows
     *
     * @return array
     */
    public function getSearchFields(): array;

    /**
     * Returns the list of allowed filter fields that client may use to filter their result
     *
     * @return array
     */
    public function getFilterFields(): array;
}
