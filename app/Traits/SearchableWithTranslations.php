<?php

namespace App\Traits;

trait SearchableWithTranslations
{
    /*
        Turns translatable JSON attributes into simple text attributes for default locale.
        Adds all translations as extra objects.
    */
    public function toSearchableArrayWithTranslations()
    {
        $array = $this->toArray();

        // Use default locale in top-level attributes
        foreach($this->getTranslatableAttributes() as $translatable) {
            $array[$translatable] = $this->$translatable;
        }

        // Store all translations in separate objects within the document
        $translations = $this->getTranslations();
        foreach(array_keys($translations) as $attribute) {
            $attributeTranslations = $translations[$attribute];

            foreach(array_keys($attributeTranslations) as $locale) {
                $array[$locale][$attribute] = $translations[$attribute][$locale];
            }
        }

        return $array;
    }
}
