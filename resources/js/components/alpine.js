import collapse from '@alpinejs/collapse';
import focus from '@alpinejs/focus'
import intersect from "@alpinejs/intersect";
import { Livewire, Alpine } from '../../../vendor/livewire/livewire/dist/livewire.esm';

window.Alpine = Alpine;

Alpine.plugin(collapse);
Alpine.plugin(focus);
Alpine.plugin(intersect);
// Alpine.start();

Livewire.start();
