<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('featured-filters') }}'><i class='nav-icon la la-filter'></i> Featured Filters</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('featured-projects', [1, 'edit']) }}'><i class='nav-icon la la-list'></i> Featured Projects</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('collections') }}'><i class='nav-icon la la-layer-group'></i> Collections</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('articles') }}'><i class='nav-icon la la-newspaper-o'></i> Articles</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('projects') }}'><i class='nav-icon la la-fire'></i> Projects</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('publications') }}'><i class='nav-icon la la-book'></i> Publications</a></li>

<li class="nav-title">Naimportované</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('architect') }}'><i class='nav-icon la la-user-alt'></i> Architects</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('building') }}'><i class='nav-icon la la-building'></i> Buildings</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('image') }}'><i class='nav-icon la la-image'></i> Images</a></li>

<li class="nav-title">Ostatné</li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('elfinder') }}"><i class="nav-icon la la-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>
<li class="nav-item"><a class="nav-link" href="{{ url('telescope') }}"><i class="nav-icon la la-moon"></i> <span>Telescope</span> <i class="la la-external-link-alt"></i></a></li>
<li class="nav-item"><a class="nav-link" href="{{ url('horizon') }}"><i class="nav-icon la la-tachometer-alt"></i> <span>Horizon</span> <i class="la la-external-link-alt"></i></a></li>
