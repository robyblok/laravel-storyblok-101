 <x-layout.base :story="$story" :language="$language">
     <x-storyblok-component :component="Arr::get($story, 'story.content')" :language="$language"/>
 </x-layout.base>
