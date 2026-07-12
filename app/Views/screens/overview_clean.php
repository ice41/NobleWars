<br>
<table>
     <tr>
          <td width="600" valign="top" valign="top">
               <table class="vis" width="100%">
                    <tr>
                         <th colspan="2">
                              <i>Edifícios</i>
                         </th>
                    </tr>
                    {if $style == 'new'}
                    <tr>
                         <td width="60%">
                              <a href="game.php?village={$village.id}&screen=overview&akcja=o_labels"><span>{if
                                        $labels}Ocultar níveis de construção{else}Mostrar níveis de
                                        construção{/if}</span></a>
                         </td>
                         <td>
                              <a href="game.php?village={$village.id}&screen=overview&akcja=o_style"><span
                                         class="text-right">Visão geral clássica da aldeia</span></a>
                         </td>
                    </tr>
                    <tr>
                         <td colspan="2">
                              <table cellpadding="5">
                                   <tr>
                                        <td>
                                             <div
                                                   style="position: relative; width: 600px; height: 418px; background-image: url(graphic/{$visual}/back_none.jpg); background-size: 100% 100%;" />
                                             <img class="empty" src="graphic/map/empty.png" alt="" usemap="#mapa" />
                                             <map name="mapa" id="mapa">
                                                  {foreach from=$cl_builds->get_array('dbname') item=dbname key=id}
                                                  {if $village.$dbname > 0}
                                                  {if $cl_builds->get_maxstage($dbname) == 1}
                                                  <area shape="poly" coords="{$builgraphic_coords.$dbname}"
                                                       href="game.php?village={$village.id}&screen={$dbname}"
                                                       alt="{$cl_builds->get_name($dbname)}"
                                                       title="{$cl_builds->get_name($dbname)}" />
                                                  {if $dbname == 'place'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d1" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d1.{$barracks}"
                                                            alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'snob'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d1" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d1.{$snob}" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'statue'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d1" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d1.png" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'church'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d3" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d3.png" alt="" /></a>
                                                  {/if}
                                                  {if $labels}
                                                  <label class="stagetip label_{$dbname}"><a
                                                            href="game.php?village={$village.id}&screen={$dbname}">{$village.$dbname}</a></label>

                                                  {/if}
                                                  {else}
                                                  {if $dbname == 'snob' || $dbname == 'hide'}
                                                  <area shape="poly" coords="{$builgraphic_coords.$dbname}"
                                                       href="game.php?village={$village.id}&screen={$dbname}"
                                                       alt="{$cl_builds->get_name($dbname)}"
                                                       title="{$cl_builds->get_name($dbname)}" />
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d1" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d1.png" alt="" /></a>
                                                  {if $labels}
                                                  <label class="stagetip label_{$dbname}"><a
                                                            href="game.php?village={$village.id}&screen={$dbname}">{$village.$dbname}</a></label>
                                                  {/if}
                                                  {else}
                                                  {php}
                                                  $this->_tpl_vars['aktu_build_prc'] =
                                                  $this->_tpl_vars['village'][$this->_tpl_vars['dbname']] /
                                                  $this->_tpl_vars['cl_builds']->get_maxstage($this->_tpl_vars['dbname']);
                                                  {/php}
                                                  {if $aktu_build_prc > 0.5}
                                                  <area shape="poly" coords="{$builgraphic_coords.$dbname}"
                                                       href="game.php?village={$village.id}&screen={$dbname}"
                                                       alt="{$cl_builds->get_name($dbname)}"
                                                       title="{$cl_builds->get_name($dbname)}" />
                                                  {if $dbname == 'main'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_mainflag"
                                                            src="graphic/{$visual}/mainflag3.gif" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'main'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d3" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d3.{$main}" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'smith'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d3" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d3.{$smith}" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'garage'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d3" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d3.{$garage}" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'stable'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d3" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d3.{$stable}" alt="" /></a>
                                                  {/if}

                                                  {if $dbname == 'wood'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d3" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d3.{$wood}" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'stone'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d3" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d3.{$stone}" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'iron'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d3" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d3.{$iron}" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'farm'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d3" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d3.{$farm}" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'barracks' || $dbname == 'wall' || $dbname == 'market'
                                                  || $dbname == 'church' || $dbname == 'storage'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d3" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d3.png" alt="" /></a>
                                                  {/if}
                                                  {if $labels}
                                                  <label class="stagetip label_{$dbname}"><a
                                                            href="game.php?village={$village.id}&screen={$dbname}">{$village.$dbname}</a></label>
                                                  {/if}
                                                  {else}
                                                  {if $aktu_build_prc > 0.2}
                                                  <area shape="poly" coords="{$builgraphic_coords.$dbname}"
                                                       href="game.php?village={$village.id}&screen={$dbname}"
                                                       alt="{$cl_builds->get_name($dbname)}"
                                                       title="{$cl_builds->get_name($dbname)}" />
                                                  {if $dbname == 'main'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_mainflag"
                                                            src="graphic/{$visual}/mainflag2.gif" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'main'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d2" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d2.{$main}" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'smith'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d2" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d2.{$smith}" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'garage'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d2" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d2.{$garage}" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'stable'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d2" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d2.{$stable}" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'church'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d2" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d2.{$church}" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'wood'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d2" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d2.{$wood}" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'stone'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d2" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d2.{$stone}" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'iron'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d2" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d2.{$iron}" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'farm'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d2" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d2.{$farm}" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'barracks' || $dbname == 'wall' || $dbname == 'market'
                                                  || $dbname == 'church' || $dbname == 'storage'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d2" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d2.png" alt="" /></a>
                                                  {/if}
                                                  {if $labels}
                                                  <label class="stagetip label_{$dbname}"><a
                                                            href="game.php?village={$village.id}&screen={$dbname}">{$village.$dbname}</a></label>
                                                  {/if}
                                                  {else}
                                                  <area shape="poly" coords="{$builgraphic_coords.$dbname}"
                                                       href="game.php?village={$village.id}&screen={$dbname}"
                                                       alt="{$cl_builds->get_name($dbname)}"
                                                       title="{$cl_builds->get_name($dbname)}" />
                                                  {if $dbname == 'main'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_mainflag"
                                                            src="graphic/{$visual}/mainflag1.gif" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'main'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d1" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d1.{$main}" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'smith'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d1" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d1.{$smith}" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'garage'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d1" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d1.{$garage}" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'stable'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d1" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d1.{$stable}" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'church'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d1" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d1.{$church}" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'wood'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d1" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d1.{$wood}" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'stone'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d1" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d1.{$stone}" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'iron'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d1" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d1.{$iron}" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'farm'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d1" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d1.{$farm}" alt="" /></a>
                                                  {/if}
                                                  {if $dbname == 'barracks' || $dbname == 'wall' || $dbname == 'market'
                                                  || $dbname == 'church' || $dbname == 'storage'}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d1" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d1.png" alt="" /></a>
                                                  {/if}
                                                  {if $labels}
                                                  <label class="stagetip label_{$dbname}"><a
                                                            href="game.php?village={$village.id}&screen={$dbname}">{$village.$dbname}</a></label>
                                                  {/if}
                                                  {/if}
                                                  {/if}
                                                  {/if}
                                                  {/if}
                                                  {else}
                                                  {php}
                                                  if
                                                  (get_counts_on_build($this->_tpl_vars['village']['id'],$this->_tpl_vars['dbname'])
                                                  > 0):
                                                  {/php}
                                                  <img class="align_\x7b\x24dbname\x7d align_\x7b\x24dbname\x7d0" src="graphic/\x7b\x24visual\x7d/\x7b\x24dbname\x7d0.gif"
                                                       alt="" />
                                                  {php}
                                                  endif;
                                                  {/php}
                                                  {/if}
                                                  {/foreach}


                                                  {if $anim == 1}
                                                  <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                                            class="align_conversation"
                                                            src="graphic/{$visual}/conversation.gif" alt="" />
                                                       {/if}
                                                       {if $anim == 2}
                                                       <img class="align_juggler" src="graphic/{$visual}/juggler.gif"
                                                            alt="" />
                                                       {/if}
                                                       {if $anim == 3}
                                                       <img class="align_guard" src="graphic/{$visual}/guard.gif"
                                                            alt="" />
                                                       {/if}
                                                       {if $village.r_bh
                                                       < $max_bh} <img class="align_farmer"
                                                            src="graphic/{$visual}/farmer.gif" alt="" />
                                                       {/if}
                                             </map>
                                             </div>
                                        </td>
                                   </tr>
                              </table>
                         </td>
                    </tr>

                    {elseif $style == 'classic'}
                    <tr>
                         <td>
                              <a href="game.php?village={$village.id}&screen=overview&akcja=o_style">
                                   <span  class="text-right">
                                        Para uma visão geral gráfica da aldeia
                                   </span>
                              </a>
                         </td>
                    </tr>
                    {foreach from=$built_builds item=dbname key=id}
                    <tr>
                         <td>
                              <a href="game.php?village={$village.id}&screen={$dbname}"><img
                                        src="graphic/buildings/{$dbname}.png"> {$cl_builds->get_name($dbname)}</a>
                              (
                              <?= __('screens.common.level') ?> {$village.$dbname})
                         </td>
                    </tr>
                    {/foreach}
                    {/if}

                    <tr>
                         {* Andere Angriffe auf das aktuelle Dorf *}
                         {if count($other_movements)>0}
                         <td colspan="2">
                              <table class="vis" width="100%">
                                   <tr>
                                        <th>Outras ordens (<?= __('screens.overview.incoming') ?: 'A chegar' ?>) ({php}echo count($this->_tpl_vars['other_movements']);{/php})
                                        </th>
                                        <th><?= __('screens.overview.at_location') ?></th>
                                        <th><?= __('screens.overview.arrival') ?></th>
                                   </tr>
                                   {foreach from=$other_movements item=array}
                                   <tr>
                                        <td>
                                             <a
                                                  href="game.php?village={$village.id}&amp;screen=info_command&amp;id={$array.id}&amp;type=other">
                                                  <img src="graphic/command/{$array.type}.png"> {$array.message}
                                             </a>
                                        </td>
                                        <td>
                                             {$array.end_time}
                                        </td>
                                        {if $array.arrival_in<0} <td>
                                             {$array.arrival_in|format_time}
                         </td>
                         {else}
                         <td>
                              <span class="timer">
                                   {$array.arrival_in|format_time}
                              </span>
                         </td>
                         {/if}
                    </tr>
                    {/foreach}
               </table>
          </td>
          {/if}
     </tr>
     <tr>
          {* Eigene losgeschickte Angriffe *}
          {if count($my_movements)>0}
          <td colspan="2">
               <br>
               <table class="vis" width="100%">
                    <tr>
                         <th>Próprias Ordens ({php}echo count($this->_tpl_vars['my_movements']);{/php})</th>
                         <th>No local</th>
                         <th>No local às</th>
                    </tr>
                    {foreach from=$my_movements item=array}
                    <tr>
                         <td>
                              <a
                                   href="game.php?village={$village.id}&amp;screen=info_command&amp;id={$array.id}&amp;type=own">
                                   <img src="graphic/command/{$array.type}.png"> {$array.message}
                               </a>
                         </td>
                         <td>
                              {$array.end_time}
                         </td>
                         {if $array.arrival_in<0} <td>
                              {$array.arrival_in|format_time}
          </td>
          {else}
          <td>
               <span class="timer">
                    {$array.arrival_in|format_time}
               </span>
          </td>
          {/if}
          {if $array.can_cancel}
          <td>
               <a
                    href="game.php?village={$village.id}&amp;screen=place&amp;action=cancel&amp;id={$array.id}&amp;h={$hkey}">
                    Cancelar
               </a>
          </td>
          {/if}
     </tr>
     {/foreach}
</table>
</td>
{/if}
</tr>
</table>
</td>

<td valign="top" {if $style=='new' }width="100%{/if}{if $style == 'classic'}width=" 40%{/if}">
     {if $noob}
     <table class="vis" width="100%">
          <tr>
               <th>
                    <i>Proteção inicial</i>
               </th>
          </tr>
          <tr>
               <td>
                    acaba {$noob_end}
               </td>
          </tr>
     </table>
     <br />
     {/if}
     <div id="show_prod" class="vis moveable widget">
          <h4 class="head">
               <img  class="float-right pointer"
                    onclick="return VillageOverview.toggleWidget( 'show_prod', this );" src="graphic/icons/minus.png">
               Produção
          </h4>
          <div class="widget_content"  style="display: block;">
               <table width="100%">
                    <tbody>
                         <tr class="nowrap">
                              <td width="70">
                                   <a href="game.php?village={$village.id}&amp;screen=wood"><span
                                             class="icon header wood"> </span></a> Madeira
                              </td>
                              <td>
                                   <strong> {$wood_per_hour|format_number}</strong> por hora
                                   <a href="javascript:void(0);" onclick="openProdBonusModal('wood'); return false;">
                                       <img src="graphic/new/premium/premium_plus.webp" alt="Premium"  class="v-align-middle pointer" style="margin-left: 5px;">
                                   </a>
                              </td>
                         </tr>
                         <tr class="nowrap">
                              <td width="70">
                                   <a href="game.php?village={$village.id}&amp;screen=stone"><span
                                             class="icon header stone"> </span></a> Argila
                              </td>
                              <td>
                                   <strong> {$stone_per_hour|format_number}</strong> por hora
                                   <a href="javascript:void(0);" onclick="openProdBonusModal('clay'); return false;">
                                       <img src="graphic/new/premium/premium_plus.webp" alt="Premium"  class="v-align-middle pointer" style="margin-left: 5px;">
                                   </a>
                              </td>
                         </tr>
                         <tr class="nowrap">
                              <td width="70">
                                   <a href="game.php?village={$village.id}&amp;screen=iron"><span
                                             class="icon header iron"> </span></a> Ferro
                              </td>
                              <td>
                                   <strong> {$iron_per_hour|format_number}</strong> por hora
                                   <a href="javascript:void(0);" onclick="openProdBonusModal('iron'); return false;">
                                       <img src="graphic/new/premium/premium_plus.webp" alt="Premium"  class="v-align-middle pointer" style="margin-left: 5px;">
                                   </a>
                              </td>
                         </tr>
                         <tr>

                         </tr>
                    </tbody>
               </table>
          </div>
     </div>

     <div  style="opacity: 1;" id="show_units" class="vis moveable widget">
          <h4 class="head">
               <img  class="float-right pointer"
                    onclick="return VillageOverview.toggleWidget( 'show_units', this );" src="graphic/icons/minus.png">
               Unidades
          </h4>
          <div class="widget_content"  style="display: block;">
               <table class="vis" width="100%">
                    <tbody>
                         {foreach from=$in_village_units item=num key=dbname}
                         <tr>
                              <td>
                                   <a href="#" class="unit_link"
                                        onclick="return UnitPopup.open(event, '{$dbname}')"><img
                                             src="graphic/unit/{$dbname}.png">
                                        <b></a>
                                   {$num}
                                   </b>
                                   {if $dbname === 'unit_paladin'}
                                   {$pala_name}
                                   {else}
                                   {$cl_units->get_name($dbname)}
                                   {/if}
                              </td>
                         </tr>
                         {/foreach}
                         <tr>
                              <td><a href="game.php?village={$village.id}&amp;screen=train&mode=train">
                                        <?= __('screens.common.recruit') ?>
                                   </a></td>
                         </tr>
                    </tbody>
               </table>
          </div>
     </div>
     <script type="text/javascript" src="/js/unit_popup.js"></script>
     {literal}
     <script type="text/javascript">
          //<![CDATA[
          $(function () {
               UnitPopup.unit_data = { "spear": { "name": "Lanceiro\u00f3w", "desc": "Lanceiro é o mais simples\u0105 unidade\u0105. É eficaz na defesa contra eles\u017ada.", "wood": 50, "stone": 30, "iron": 10, "pop": 1, "speed": 0.0009259259259, "attack": 10, "attack_buildings": null, "defense": 15, "defense_cavalry": 45, "defense_archer": 20, "carry": 25, "type": "infantry", "image": "unit\/unit_spear.png", "prod_building": "barracks", "attackpoints": 4, "defpoints": 1, "build_time": 1020, "shortname": "Lança", "count": "40", "reqs": [{ "building_id": "barracks", "building_link": "\/game.php?village=5886&amp;screen=barracks", "name": "Quartel", "level": 1 }] }, "sword": { "name": "Espadachim\u00f3w", "desc": "Espadachim s\u0105 eficaz contra a infantaria. Jogada\u0105 si\u0119 porém bem devagar.", "wood": 30, "stone": 30, "iron": 70, "pop": 1, "speed": 0.0007575757576, "attack": 25, "attack_buildings": null, "defense": 50, "defense_cavalry": 15, "defense_archer": 40, "carry": 15, "type": "infantry", "image": "unit\/unit_sword.png", "prod_building": "barracks", "attackpoints": 5, "defpoints": 2, "build_time": 1500, "shortname": "Espada", "count": "21", "reqs": [{ "building_id": "smith", "building_link": "\/game.php?village=5886&amp;screen=smith", "name": "Ferreiro", "level": 1 }] }, "axe": { "name": "Viking\u00f3w", "desc": "Viking to mocna jednostka atakuj\u0105ca. Jak szaleni atakuj\u0105 wioski przeciwnik\u00f3w.", "wood": 60, "stone": 30, "iron": 40, "pop": 1, "speed": 0.0009259259259, "attack": 40, "attack_buildings": null, "defense": 10, "defense_cavalry": 5, "defense_archer": 10, "carry": 10, "type": "infantry", "image": "unit\/unit_axe.png", "prod_building": "barracks", "attackpoints": 1, "defpoints": 4, "build_time": 1320, "shortname": "Viking", "count": "10", "reqs": [{ "building_id": "smith", "building_link": "\/game.php?village=5886&amp;screen=smith", "name": "Ku\u017ania", "level": 2 }], "tech_costs": { "wood": 700, "stone": 840, "iron": 820 } }, "knight": { "name": "Paladino", "desc": "Paladino chroni twoj\u0105 wiosk\u0119, jak r\u00f3wnie\u017c twoich sprzymierze\u0144c\u00f3w, przed obcymi napadami. Ka\u017cdy gracz mo\u017ce posiada\u0107 tylko jednego rycerza.", "wood": 20, "stone": 20, "iron": 40, "pop": 10, "speed": 0.001666666667, "attack": 150, "attack_buildings": null, "defense": 250, "defense_cavalry": 400, "defense_archer": 150, "carry": 100, "type": "cavalry", "image": "unit\/unit_knight.png", "prod_building": "statue", "attackpoints": 40, "defpoints": 20, "build_time": 21600, "shortname": "Paladino" } };
               UnitPopup.init();
          });
          //]]>
     </script>{/literal}
     <script type="text/javascript" src="./js/promo_popup.js?1378724545"></script>
     <script type="text/javascript" src="./js/overniew.js?1378724545"></script>
     <div id="inline_popup" class="hidden"  style="width:700px;">
          <div id="inline_popup_menu">
               <span id="inline_popup_title"></span>
               <a id="inline_popup_close" href="javascript:inlinePopupClose()">X</a>
          </div>
          <div id="inline_popup_main"  style="height: auto;">
               <div id="inline_popup_content"></div>
          </div>
     </div>

     <div id="unit_popup_template"  style="display: none;">
          <div class="inner-border main content-border"  style="border: none; font-weight: normal;">
               <table  class="float-left" style="width:450px;">
                    <tr>
                         <td>
                              <p class="unit_desc"></p>
                         </td>
                    </tr>
                    <tr>
                         <td>
                              <table  style="border: 1px solid #DED3B9;" class="vis" width="100%">
                                   <tr>
                                        <th width="180">Koszta</th>
                                        <th>População</th>
                                        <th>Velocidade</th>
                                        <th>Carregar</th>
                                   </tr>
                                   <tr class="center">
                                        <td>
                                             <nobr><span class="icon header wood"> </span><span
                                                       class="unit_wood"></span></nobr>
                                             <nobr><span class="icon header stone"> </span><span
                                                       class="unit_stone"></span></nobr>
                                             <nobr><span class="icon header iron"> </span><span
                                                       class="unit_iron"></span></nobr>
                                        </td>
                                        <td><span class="icon header population"> </span><span class="unit_pop"></span>
                                        </td>
                                        <td id="unit_speed"></td>
                                        <td class="unit_carry"></td>
                                   </tr>
                              </table>
                              <br />

                              <table class="vis event_loot w-100"  style="display: none;">
                                   <tr>
                                        <th colspan="2">Detalhes do evento</th>
                                   </tr>
                                   <tr>
                                        <td>Carregar:</td>
                                        <td><span class="unit_event_loot"></span> <span
                                                  class="unit_event_res_name"></span></td>
                              </table>
                              <br />

                              <table class="vis has_levels_only text-center"  style="border: 1px solid #DED3B9;"
                                   class="vis" width="100%">
                                   <tr>
                                        <th colspan="3">Estatísticas de batalha</th>
                                   </tr>
                                   <tr>
                                        <td align="left">A força do ataque</td>
                                        <td width="20px"><img src="../graphic/unit/att.png?1bdd4"
                                                  alt="A força do ataque" /></td>
                                        <td><span class="unit_attack"></span></td>
                                   </tr>
                                   <tr>
                                        <td align="left">Defesa em geral</td>
                                        <td><img src="../graphic/unit/def.png?12421" alt="Defesa em geral" /></td>
                                        <td><span class="unit_defense"></span></td>
                                   </tr>
                                   <tr>
                                        <td align="left">Defesa contra cavalaria</td>
                                        <td><img src="../graphic/unit/def_cav.png?46b3d"
                                                  alt="Defesa contra cavalaria" /></td>
                                        <td><span class="unit_defense_cavalry"></span></td>
                                   </tr>
                                   <tr>
                                        <td align="left">Defesa contra arqueiros</td>
                                        <td><img src="../graphic/unit/def_archer.png?faccf"
                                                  alt="Defesa contra arqueiros" /></td>
                                        <td><span class="unit_defense_archer"></span></td>
                                   </tr>
                              </table>
                              <br />

                              <div class="show_if_has_reqs">
                                   <table class="vis" width="100%">
                                        <tr>
                                             <th id="reqs_count" colspan="1">Requisitos para poder pesquisar uma unidade
                                             </th>
                                        </tr>
                                        <tr id="reqs"></tr>
                                   </table>
                                   <br />
                              </div>

                              <table class="unit_tech vis unit_tech_levels" width="100%">
                                   <tr  class="text-center">
                                        <th>
                                             <?= __('screens.common.tech_level') ?>
                                        </th>
                                        <th width="350">Custos de teste (se necessário)</th>
                                        <th width="30"  class="text-center"><img
                                                  src="../graphic/unit/att.png?1bdd4" alt="A força do ataque" /></th>
                                        <th width="30"  class="text-center"><img
                                                  src="../graphic/unit/def.png?12421" alt="Defesa em geral" /></th>
                                        <th width="30"  class="text-center"><img
                                                  src="../graphic/unit/def_cav.png?46b3d"
                                                  alt="Defesa contra cavalaria" /></th>
                                        <th width="30"  class="text-center"><img
                                                  src="../graphic/unit/def_archer.png?faccf"
                                                  alt="Defesa contra arqueiros" /></th>
                                   </tr>
                                   <tr id="unit_tech_prototype"  class="text-center" style="display: none;">
                                        <td class="tech_level"></td>
                                        <td>
                                             <span class="grey tech_researched">já pesquisado</span>
                                             <span class="tech_res_list">
                                                  <span class="icon header wood"> </span><span class="tech_wood"></span>
                                                  <span class="icon header stone"> </span><span
                                                       class="tech_stone"></span> <span class="icon header iron">
                                                  </span><span class="tech_iron"></span>
                                             </span>
                                        </td>
                                        <td class="tech_att"></td>
                                        <td class="tech_def"></td>
                                        <td class="tech_def_cav"></td>
                                        <td class="tech_def_archer"></td>
                                   </tr>
                              </table>
                              <table class="vis unit_tech unit_tech_cost" width="100%">
                                   <tr>
                                        <th>Custos de teste (se necessário)</th>
                                   </tr>
                                   <tr>
                                        <td><span class="icon header wood"> </span><span class="tech_cost_wood"></span>
                                             <span class="icon header stone"> </span><span
                                                  class="tech_cost_stone"></span> <span class="icon header iron">
                                             </span><span class="tech_cost_iron"></span></td>
                                   </tr>
                              </table>
                         </td>
                    </tr>
               </table>
               <img  style="margin-top: 60px; max-width: 200px; display: none;" id="unit_image"
                    src="graphic/map/empty.png" alt="" />
          </div>
     </div>

     <div id="show_group" class="vis moveable widget">
          <h4 class="head">
               <img  class="float-right pointer"
                    onclick="return VillageOverview.toggleWidget( 'show_group', this );" src="graphic/icons/minus.png"> Grupo
          </h4>
          <div class="widget_content" >
               <table class="vis" width="100%">
                    <tbody> {if $village.group === 'all'}
                         <tr>
                              <td>
                                   <a
                                        href="game.php?village={$village.id}&amp;screen=overview_villages&amp;mode=grocusto">Adicionar</a>
                              </td>
                         </tr>
                         {else}
                         <tr>
                              <td>
                                   {$village.group}
                              </td>
                         </tr>
                         <tr>
                              <td>
                                   <a
                                        href="game.php?village={$village.id}&amp;screen=overview_villages&amp;mode=grocusto">Adicionar</a>
                              </td>
                         </tr>
                         {/if}
                    </tbody>
               </table>
          </div>
     </div>


     <br />
     <br />
     {literal} <style>
          .green-bar {
               height: 5px;
               background-color: green;
          }

          .yellow-bar {
               height: 5px;
               background-color: yellow;
          }

          .orange-bar {
               height: 5px;
               background-color: orange;
          }

          .red-bar {
               height: 5px;
               background-color: red;
          }
     </style>


     {/literal}

     <div id="show_agreement" class="vis moveable widget">
          <h4 class="head">
               <img  class="float-right pointer"
                    onclick="return VillageOverview.toggleWidget( 'show_agreement', this );" src="graphic/icons/minus.png">
               Moral
          </h4>
          <div class="widget_content" >
               <table class="vis" width="100%">
                    <tbody>
                         <tr>
                              <div id="pop">
                                   <t{if $color==yellow}h{else}d{/if}  style="color: {$color};">
                                        <center>{$village.agreement} / <font color="green">100</font>
                                        </center>
                                        <div class="{$color}-bar"  style="width: {$village.agreement}%;">
</td>
</div>
</tr>
</tbody>
</table>
</div>
</div>


{if $village.bonus == 0 && $premium}<div id="show_b" class="vis moveable widget">
     <h4 class="head">
          <img  class="float-right pointer" onclick="return VillageOverview.toggleWidget( 'show_b', this );"
               src="graphic/icons/minus.png"> Resgatar um bônus de aldeia!
     </h4>
     <div class="widget_content" >
          <table class="vis" width="100%">
               <tbody>
                    <tr>

                         Se quiser comprar um bônus para aldeia, deve ter Pontos Premium :<center><a
                                   href="game.php?village={$village.id}&screen=codigos"><?= __('screens.overview.codes') ?: 'códigos' ?></a></center>
                         {if $user.premium_p >= 50}
                         <form action="game.php?village={$village.id}&screen=overview&akcja=bonus" method="post">
                              <td><?= __('screens.overview.premium_points') ?: 'Pontos premium:' ?> <b>{$ilosc_sz}</b></td>
                    <tr>
                         <td><b><?= __('screens.overview.bonus_cost') ?: 'Um bônus custa 50 Premium!' ?></b></td>
                    <tr>
                         <th><?= __('screens.overview.choose_bonus') ?: 'Escolha um bônus:' ?></th>
                    <tr>
                         <td><input type="radio" name="bonus" value="1" checked="checked" /> Aumento da capacidade da
                              fazenda e comerciantes
                    <tr>
                         <td><input type="radio" name="bonus" value="2" /> Aumento da produção de recursos (todos os
                              recursos)
                    <tr>
                         <td><input type="radio" name="bonus" value="3" /> Mais produção de madeira
                    <tr>
                         <td><input type="radio" name="bonus" value="4" /> Mais produção de argila
                    <tr>
                         <td><input type="radio" name="bonus" value="5" /> Aumento da produção de ferro
                    <tr>
                         <td><input type="radio" name="bonus" value="6" /> Treinamento mais rápido no quartel
                    <tr>
                         <td><input type="radio" name="bonus" value="7" /> Treinamento mais rápido nos estábulos
                    <tr>
                         <td><input type="radio" name="bonus" value="8" /> Produção mais rápida na oficina
                    <tr>
                         <td><input type="radio" name="bonus" value="9" /> Mais população
                    <tr>
                         <td>
                              <center><input type="submit" class="btn btn-build" value="Comprar Bônus!" /> </center>
                              </form>
                              {/if}
                    </tr>
               </tbody>
          </table>
     </div>
</div> {/if}

</table>
<script>
     $(function () { ldelim } if (document.location.hash == "#bonus_1_dodany") UI.SuccessMessage("O bônus foi adicionado!", 3000); { rdelim });
     $(function () { ldelim } if (document.location.hash == "#bonus_2_dodany") UI.SuccessMessage("O bônus foi adicionado!", 3000); { rdelim });
     $(function () { ldelim } if (document.location.hash == "#bonus_3_dodany") UI.SuccessMessage("O bônus foi adicionado!", 3000); { rdelim });
     $(function () { ldelim } if (document.location.hash == "#bonus_4_dodany") UI.SuccessMessage("O bônus foi adicionado!", 3000); { rdelim });
     $(function () { ldelim } if (document.location.hash == "#bonus_5_dodany") UI.SuccessMessage("O bônus foi adicionado!", 3000); { rdelim });
     $(function () { ldelim } if (document.location.hash == "#bonus_6_dodany") UI.SuccessMessage("O bônus foi adicionado!", 3000); { rdelim });
     $(function () { ldelim } if (document.location.hash == "#bonus_7_dodany") UI.SuccessMessage("O bônus foi adicionado!", 3000); { rdelim });
     $(function () { ldelim } if (document.location.hash == "#bonus_8_dodany") UI.SuccessMessage("O bônus foi adicionado!", 3000); { rdelim });
     $(function () { ldelim } if (document.location.hash == "#bonus_9_dodany") UI.SuccessMessage("O bônus foi adicionado!", 3000); { rdelim });

</script>

<?php
$active_features_overview = [];
$now_time = time();
foreach (['wood_production', 'clay_production', 'iron_production'] as $col) {
    $expires = $user[$col . '_expires'] ?? 0;
    if ($expires && !is_numeric($expires)) {
        $expires = strtotime($expires);
    }
    if ($expires > $now_time) {
        $active_features_overview[$col] = [
            'expires' => $expires,
            'expires_formatted' => date('d M Y, H:i', $expires),
            'auto_renew' => !empty($user[$col . '_auto_renew'])
        ];
    }
}
?>
{literal}
<script type="text/javascript">
    window.overviewActiveFeatures = {/literal}<?= json_encode($active_features_overview) ?>{literal};
    window.userPremiumPoints = {/literal}<?= (int) ($ilosc_sz ?? 0) ?>{literal};

    function openProdBonusModal(feature) {
        const featureInfo = {
            'wood': {
                'id': 'wood_production',
                'name': 'madeira',
                'title': '+20% na produção de madeira',
                'img': 'graphic/new/premium/WoodProduction_large.webp',
                'desc': 'Produza mais 20% de madeira!'
            },
            'clay': {
                'id': 'clay_production',
                'name': 'argila',
                'title': '+20% na produção de argila',
                'img': 'graphic/new/premium/StoneProduction_large.webp',
                'desc': 'Produza mais 20% de argila!'
            },
            'iron': {
                'id': 'iron_production',
                'name': 'ferro',
                'title': '+20% na produção de ferro',
                'img': 'graphic/new/premium/IronProduction_large.webp',
                'desc': 'Produza mais 20% de ferro!'
            }
        };

        const info = featureInfo[feature];
        if (!info) return;

        const activeInfo = window.overviewActiveFeatures[info.id];
        const isActive = !!activeInfo;

        // Populate modal values
        document.getElementById('pbm-title').textContent = info.title;
        document.getElementById('pbm-img').src = info.img;
        document.getElementById('pbm-desc').textContent = info.desc;
        document.getElementById('pbm-feature-id').value = info.id;

        // Checkmark state
        document.getElementById('pbm-check').style.display = isActive ? 'block' : 'none';

        // Expiry display
        const expiryDiv = document.getElementById('pbm-expiry-info');
        if (isActive) {
            expiryDiv.style.display = 'block';
            document.getElementById('pbm-expiry-date').textContent = activeInfo.expires_formatted;
            document.getElementById('pbm-auto-renew-checkbox').checked = activeInfo.auto_renew;
        } else {
            expiryDiv.style.display = 'none';
        }

        // Action button text
        const actBtn = document.getElementById('pbm-btn-activate');
        actBtn.textContent = isActive ? 'PROLONGAR AGORA' : 'ATIVAR AGORA';

        // Hide gift section on start
        document.getElementById('pbm-gift-section').style.display = 'none';
        document.getElementById('pbm-gift-recipient').value = '';
        document.getElementById('pbm-gift-message').style.display = 'none';

        // Update cost display
        updatePbmCost();

        // Show modal overlay
        document.getElementById('prodBonusModalOverlay').style.display = 'flex';
    }

    function closeProdBonusModal() {
        document.getElementById('prodBonusModalOverlay').style.display = 'none';
    }

    function updatePbmCost() {
        const durationSelect = document.getElementById('pbm-duration-select');
        const duration = parseInt(durationSelect.value);
        const cost = duration === 90 ? 450 : 150;
        document.getElementById('pbm-cost-value').textContent = cost;
    }

    function togglePbmGiftSection() {
        const section = document.getElementById('pbm-gift-section');
        section.style.display = section.style.display === 'none' ? 'block' : 'none';
    }

    function submitPbmActivation() {
        const featureId = document.getElementById('pbm-feature-id').value;
        const duration = parseInt(document.getElementById('pbm-duration-select').value);
        const cost = duration === 90 ? 450 : 150;

        if (window.userPremiumPoints < cost) {
            alert("Pontos Premium insuficientes!");
            return;
        }

        const btn = document.getElementById('pbm-btn-activate');
        const originalText = btn.textContent;
        btn.disabled = true;
        btn.textContent = 'A processar...';

        const formData = new FormData();
        formData.append('action', 'activate');
        formData.append('feature', featureId);
        formData.append('duration', duration);

        fetch('game.php?screen=premium', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            btn.disabled = false;
            btn.textContent = originalText;
            if (data.success) {
                alert(data.message);
                window.location.reload();
            } else {
                alert(data.message || 'Erro ao ativar a funcionalidade.');
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.textContent = originalText;
            alert('Erro ao ligar ao servidor.');
            console.error(err);
        });
    }

    function togglePbmAutoRenew(checked) {
        const featureId = document.getElementById('pbm-feature-id').value;
        const formData = new FormData();
        formData.append('action', 'toggle_auto_renew');
        formData.append('feature', featureId);
        formData.append('enabled', checked ? '1' : '0');

        fetch('game.php?screen=premium', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if (!data.success) {
                alert(data.message || 'Erro ao alterar renovação automática.');
            }
        })
        .catch(err => {
            alert('Erro ao ligar ao servidor.');
            console.error(err);
        });
    }

    function submitPbmGift() {
        const featureId = document.getElementById('pbm-feature-id').value;
        const duration = parseInt(document.getElementById('pbm-duration-select').value);
        const recipient = document.getElementById('pbm-gift-recipient').value.trim();
        const msgDiv = document.getElementById('pbm-gift-message');

        if (!recipient) {
            msgDiv.style.color = 'red';
            msgDiv.textContent = 'Por favor, insere o nome do destinatário.';
            msgDiv.style.display = 'block';
            return;
        }

        msgDiv.style.color = '#8B4513';
        msgDiv.textContent = 'A processar...';
        msgDiv.style.display = 'block';

        const formData = new FormData();
        formData.append('action', 'gift_feature');
        formData.append('feature', featureId);
        formData.append('duration', duration);
        formData.append('recipient', recipient);

        fetch('game.php?screen=premium', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                msgDiv.style.color = 'green';
                msgDiv.textContent = data.message;
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                msgDiv.style.color = 'red';
                msgDiv.textContent = data.message || 'Erro ao enviar presente.';
            }
        })
        .catch(err => {
            msgDiv.style.color = 'red';
            msgDiv.textContent = 'Erro ao ligar ao servidor.';
            console.error(err);
        });
    }
</script>

<style type="text/css">
    #prodBonusModalOverlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 10000;
        display: none;
        justify-content: center;
        align-items: center;
    }
    .prod-bonus-card {
        background: #F4E4BC;
        border: 3px solid #8B4513;
        border-radius: 10px;
        width: 380px;
        box-sizing: border-box;
        padding: 20px;
        position: relative;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
        text-align: left;
    }
    .prod-bonus-header {
        background: #8B4513;
        color: white;
        padding: 10px;
        text-align: center;
        border-radius: 5px;
        font-weight: bold;
        font-size: 15px;
        margin-bottom: 15px;
        margin-top: 10px;
    }
    .prod-bonus-close {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #8B4513;
        color: white;
        border: none;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 15px;
        line-height: 26px;
        text-align: center;
        font-weight: bold;
    }
    .prod-bonus-check {
        position: absolute;
        top: 45px;
        right: 20px;
        font-size: 48px;
        color: green;
        line-height: 1;
        font-weight: bold;
    }
    .prod-bonus-img {
        text-align: center;
        margin: 20px 0;
    }
    .prod-bonus-img img {
        width: 100px;
        height: 100px;
    }
    .prod-bonus-desc {
        font-size: 14px;
        font-weight: bold;
        color: #3e2723;
        margin-bottom: 10px;
        text-align: center;
    }
    .prod-bonus-bullets {
        margin: 10px 0;
        padding-left: 20px;
        font-size: 13px;
        color: #3e2723;
    }
    .prod-bonus-controls {
        margin: 20px 0 15px 0;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 13px;
        color: #3e2723;
    }
    .prod-bonus-controls select {
        padding: 4px;
        border: 1px solid #8B4513;
        background: #F4E4BC;
        color: #3e2723;
        font-weight: bold;
    }
    .prod-bonus-btn-activate {
        display: block;
        width: 100%;
        padding: 10px;
        background: #228B22;
        color: white;
        border: none;
        border-radius: 4px;
        font-weight: bold;
        cursor: pointer;
        font-size: 14px;
        margin-bottom: 10px;
        transition: 0.2s;
        text-align: center;
    }
    .prod-bonus-btn-activate:hover {
        background: #006400;
    }
    .prod-bonus-auto-renew {
        background: #E7F3FF;
        border: 1px solid #2196F3;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 4px;
        font-size: 12px;
        color: #0d47a1;
    }
    .prod-bonus-btn-gift {
        display: block;
        width: 100%;
        padding: 8px;
        background: #8B4513;
        color: white;
        border: none;
        border-radius: 4px;
        font-weight: bold;
        cursor: pointer;
        font-size: 13px;
        text-align: center;
    }
    .prod-bonus-btn-gift:hover {
        background: #5d330c;
    }
</style>

<div id="prodBonusModalOverlay" onclick="if(event.target===this) closeProdBonusModal();">
    <div class="prod-bonus-card">
        <button type="button" class="prod-bonus-close" onclick="closeProdBonusModal()">✕</button>
        
        <div id="pbm-check" class="prod-bonus-check"  style="display: none;">✓</div>

        <div class="prod-bonus-header" id="pbm-title">+20% na produção de madeira</div>
        
        <div class="prod-bonus-img">
            <img id="pbm-img" src="graphic/new/premium/WoodProduction_large.webp" alt="Resource">
        </div>

        <div class="prod-bonus-desc" id="pbm-desc">Produza mais 20% de madeira!</div>

        <ul class="prod-bonus-bullets">
            <li>Em todas as aldeias</li>
        </ul>

        <div class="prod-bonus-controls">
            <img src="graphic/new/premium/time.png"  class="v-align-middle" alt="Duration" />
            <select id="pbm-duration-select" onchange="updatePbmCost()">
                <option value="90">90 dias</option>
                <option value="30">30 dias</option>
            </select>
            <img src="graphic/new/premium/coinbag_15x15.png"  class="v-align-middle" alt="Coins" />
            <strong><span id="pbm-cost-value">450</span> pontos</strong>
        </div>

        <input type="hidden" id="pbm-feature-id" value="">

        <button type="button" class="prod-bonus-btn-activate" id="pbm-btn-activate" onclick="submitPbmActivation()">ATIVAR AGORA</button>

        <!-- Auto-renew & Expiry section -->
        <div id="pbm-expiry-info" class="prod-bonus-auto-renew"  style="display: none;">
            <label  class="pointer bold mb-5" style="display: block;">
                <input type="checkbox" id="pbm-auto-renew-checkbox" onchange="togglePbmAutoRenew(this.checked)">
                Prolongar automaticamente
            </label>
            <small>Expira a <span id="pbm-expiry-date"></span></small>
        </div>

        <!-- Comprar como Presente section -->
        <button type="button" class="prod-bonus-btn-gift" onclick="togglePbmGiftSection()">COMPRAR COMO PRESENTE</button>
        
        <div id="pbm-gift-section"  class="mt-15" style="display: none; border-top: 1px solid #8B4513; padding-top: 15px;">
            <div  class="bold mb-5" style="font-size: 12px; color: #8B4513;">Comprar como presente:</div>
            <div  style="display: flex; gap: 8px;">
                <input type="text" id="pbm-gift-recipient" placeholder="Nome do jogador"  class="p-5" style="background: rgba(0,0,0,0.1); border: 1px solid #8B4513; flex-grow: 1; border-radius: 4px; outline: none; font-size: 13px;">
                <button type="button" onclick="submitPbmGift()"  class="bold pointer" style="background: #8B4513; color: white; border: none; padding: 5px 12px; border-radius: 4px; font-size: 12px;">Enviar</button>
            </div>
            <div id="pbm-gift-message"  class="mt-5 bold" style="font-size: 11px; display: none;"></div>
        </div>
    </div>
</div>
{/literal}