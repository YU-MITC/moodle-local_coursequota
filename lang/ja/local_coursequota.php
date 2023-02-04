<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Language file for "Course Quota".
 *
 * @package   local_coursequota
 * @copyright (C) 2023 2Yamaguchi University <gh-cc@mlex.cc.yamaguchi-u.ac.jp>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author    Tomoya Saito
 */

$string['pluginname'] = 'コース・クオータ';

// Capability strings.
$string['coursequota:allow'] = 'すべての操作を許可';

// Settings.
$string['enable_quota'] = 'コンテンツ数に基づくクオータを有効';
$string['enable_quota_desc'] = '有効に設定した場合、コンテンツ数が制限を超えたコースでは教師に対して警告が表示されます。また、該当のコースでは新たなコンテンツ（活動やリソース）の追加を禁止することができます。';
$string['quota_action'] = 'クオータの動作';
$string['quota_action_desc'] = '制限に該当するコースへの措置を選択します。';
$string['warningonly'] = '警告のみ';
$string['prohibit'] = '禁止';
$string['regular_limit'] = '通常の上限';
$string['regular_limit_desc'] = '通常のコースに適用するコンテンツ数の上限。 0に設定すると無制限。';
$string['special_limit'] = '特別な上限';
$string['special_limit_desc'] = '特別なコースに適用するコンテンツ数の上限。 0に設定すると無制限。';
$string['special_courses'] = '特別なコース';
$string['special_courses_desc'] = '特別な制限を適用するコースの省略名を記入してください。 省略名は1つずつ改行してください。';
$string['regular_percentage'] = '警告しきい値 (通常のコース)';
$string['regular_percentage_desc'] = '上限に対するコンテンツ数のパーセンテージがこの値を超えると警告を表示。';
$string['special_percentage'] = '警告しきい値 (特別なコース)';
$string['special_percentage_desc'] = '上限に対するコンテンツ数のパーセンテージがこの値を超えると警告を表示。';
$string['warning_message'] = 'このコースのコンテンツ数 ({$a->contents}) は上限 ({$a->limit}) に近くなっています。';
$string['critical_message'] = 'このコースのコンテンツ数 ({$a->contents}) は上限 ({$a->limit}) に達しています。';
$string['changed'] = 'ケイパビリティを変更しました。';
$string['notchanged'] = 'ケイパビリティは変更されませんでした。';
$string['multichanged'] = '{$a} 個のコースのケイパビリティが変更されました。';

// Privacy strings.
$string['privacy:metadata'] = 'コース・クオータプラグインはいかなる個人情報も保存しません。';

