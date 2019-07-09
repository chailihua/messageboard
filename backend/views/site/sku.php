<?php
/**
 * Created by PhpStorm.
 */

use common\widget\sku\SkuAssest;
use yii\helpers\Html;
SkuAssest::register($this);
$this->registerCss('
.notchoose{
    border:1px solid grey;
    color:#A4A4A4;
}
');
?>


<style type="text/css">
.bh-sku-selected {color: red;}
</style>
<script type="text/javascript">
var startTime = new Date().getTime();
//销售属性集
var keys = [
        ['10'],
        ['20','21','22','23','24'],
        ['30','31','32','33','34','35','36','37','38'],
        ['40']
        ];

//后台读取结果集
var data = {
    // "10;24;31;40": {
    //     price:366,
    //     count:46
    // },
    // "10;24;32;40": {
    //     price:406,
    //     count:66
    // },
    "24;33;10;40": {
        price:123,
        count:77
    },
    "10;24;34;40": {
        price:456,
        count:9
    },
    "10;24;35;40": {
        price:371,
        count:33
    },
    "10;24;36;40": {
        price:411,
        count:79
    },
    "10;24;37;40": {
        price:421,
        count:87
    },
    "10;24;38;40": {
        price:461,
        count:9
    },
    "10;24;30;40": {
        price:356,
        count:59
    },
    "10;23;31;40": {
        price:366,
        count:50
    },
    "10;23;32;40": {
        price:406,
        count:9
    },
    "10;23;33;40": {
        price:416,
        count:90
    },
    "10;23;34;40": {
        price:456,
        count:10
    },
    "10;23;35;40": {
        price:371,
        count:79
    },
    "10;23;36;40": {
        price:411,
        count:90
    },
    "10;23;37;40": {
        price:421,
        count:10
    },
    "10;23;38;40": {
        price:461,
        count:9
    },
    "10;23;30;40": {
        price:356,
        count:46
    },
    "10;22;31;40": {
        price:356,
        count:27
    },
    "10;22;32;40": {
        price:396,
        count:38
    },
    "10;22;33;40": {
        price:406,
        count:42
    },
    "10;22;34;40": {
        price:446,
        count:50
    },
    "10;22;35;40": {
        price:361,
        count:25
    },
    "10;22;36;40": {
        price:401,
        count:40
    },
    "10;22;37;40": {
        price:411,
        count:43
    },
    "10;22;38;40": {
        price:451,
        count:42
    },
    "10;21;31;40": {
        price:366,
        count:79
    },
    "10;21;32;40": {
        price:406,
        count:79
    },
    "10;21;33;40": {
        price:416,
        count:10
    },
    "10;21;34;40": {
        price:456,
        count:10
    },
    "10;21;35;40": {
        price:371,
        count:87
    },
    "10;21;36;40": {
        price:411,
        count:10
    },
    "10;21;37;40": {
        price:421,
        count:10
    },
    "10;21;38;40": {
        price:461,
        count:80
    },
    "10;21;30;40": {
        price:356,
        count:43
    },
    "10;20;31;40": {
        price:356,
        count:46
    },
    "10;20;32;40": {
        price:396,
        count:49
    },
    "10;20;33;40": {
        price:406,
        count:65
    },
    "10;20;34;40": {
        price:446,
        count:10
    },
    "10;20;35;40": {
        price:361,
        count:34
    },
    "10;20;36;40": {
        price:401,
        count:41
    },
    "10;20;37;40": {
        price:411,
        count:36
    },
    "10;20;38;40": {
        price:451,
        count:42
    },
    "10;20;30;40": {
        price:346,
        count: 3
    }
}
//保存最后的组合结果信息
var SKUResult = {};
//获得对象的key
function getObjKeys(obj) {
    if (obj !== Object(obj)) throw new TypeError('Invalid object');
    var keys = [];
    for (var key in obj)
        if (Object.prototype.hasOwnProperty.call(obj, key))
            keys[keys.length] = key;
    return keys;
}

//把组合的key放入结果集SKUResult
function add2SKUResult(combArrItem, sku) {
    var key = combArrItem.join(";");
    if(SKUResult[key]) {//SKU信息key属性·
        SKUResult[key].count += sku.count;
        SKUResult[key].prices.push(sku.price);
    } else {
        SKUResult[key] = {
            count : sku.count,
            prices : [sku.price]
        };
    }
}

//初始化得到结果集
function initSKU() {
    var i, j, skuKeys = getObjKeys(data);
    for(i = 0; i < skuKeys.length; i++) {
        var skuKey = skuKeys[i];//一条SKU信息key
        var sku = data[skuKey];	//一条SKU信息value
        var skuKeyAttrs = skuKey.split(";"); //SKU信息key属性值数组
        skuKeyAttrs.sort(function(value1, value2) {
            return parseInt(value1) - parseInt(value2);
        });

        //对每个SKU信息key属性值进行拆分组合
        var combArr = combInArray(skuKeyAttrs);
        for(j = 0; j < combArr.length; j++) {
            add2SKUResult(combArr[j], sku);
        }

        //结果集接放入SKUResult
        SKUResult[skuKeyAttrs.join(";")] = {
            count:sku.count,
            prices:[sku.price]
        }
    }
}

/**
 * 从数组中生成指定长度的组合
 * 方法: 先生成[0,1...]形式的数组, 然后根据0,1从原数组取元素，得到组合数组
 */
function combInArray(aData) {
    if(!aData || !aData.length) {
        return [];
    }

    var len = aData.length;
    var aResult = [];

    for(var n = 1; n < len; n++) {
        var aaFlags = getCombFlags(len, n);
        while(aaFlags.length) {
            var aFlag = aaFlags.shift();
            var aComb = [];
            for(var i = 0; i < len; i++) {
                aFlag[i] && aComb.push(aData[i]);
            }
            aResult.push(aComb);
        }
    }

    return aResult;
}


/**
 * 得到从 m 元素中取 n 元素的所有组合
 * 结果为[0,1...]形式的数组, 1表示选中，0表示不选
 */
function getCombFlags(m, n) {
    if(!n || n < 1) {
        return [];
    }

    var aResult = [];
    var aFlag = [];
    var bNext = true;
    var i, j, iCnt1;

    for (i = 0; i < m; i++) {
        aFlag[i] = i < n ? 1 : 0;
    }

    aResult.push(aFlag.concat());

    while (bNext) {
        iCnt1 = 0;
        for (i = 0; i < m - 1; i++) {
            if (aFlag[i] == 1 && aFlag[i+1] == 0) {
                for(j = 0; j < i; j++) {
                    aFlag[j] = j < iCnt1 ? 1 : 0;
                }
                aFlag[i] = 0;
                aFlag[i+1] = 1;
                var aTmp = aFlag.concat();
                aResult.push(aTmp);
                if(aTmp.slice(-n).join("").indexOf('0') == -1) {
                    bNext = false;
                }
                break;
            }
            aFlag[i] == 1 && iCnt1++;
        }
    }
    return aResult;
}
//初始化用户选择事件
<?php
$js = <<<JS
$(function() {
	initSKU();
	var endTime = new Date().getTime();
	$('#init_time').text('init sku time: ' + (endTime - startTime) + " ms");
	$('.sku').each(function() {
		var self = $(this);
		var attr_id = self.attr('attr_id');
		if(!SKUResult[attr_id]) {
			self.attr('disabled', 'disabled');
		}
	}).click(function() {
		var self = $(this);

		//选中自己，兄弟节点取消选中
		self.toggleClass('bh-sku-selected').siblings().removeClass('bh-sku-selected');

		//已经选择的节点
		var selectedObjs = $('.bh-sku-selected');
		if(selectedObjs.length) {
			//获得组合key价格
			var selectedIds = [];
			selectedObjs.each(function() {
				selectedIds.push($(this).attr('attr_id'));
			});
			selectedIds.sort();
			var len = selectedIds.length;
			var prices = SKUResult[selectedIds.join(';')].prices;
			console.log(prices)
			var maxPrice = Math.max.apply(null, prices);
			var minPrice = Math.min.apply(null, prices);
			$('#price').text(maxPrice > minPrice ? minPrice + "-" + maxPrice : maxPrice);

			//用已选中的节点验证待测试节点 underTestObjs
			$(".sku").not(selectedObjs).not(self).each(function() {
				var siblingsSelectedObj = $(this).siblings('.bh-sku-selected');
				var testAttrIds = [];//从选中节点中去掉选中的兄弟节点
				if(siblingsSelectedObj.length) {
					var siblingsSelectedObjId = siblingsSelectedObj.attr('attr_id');
					for(var i = 0; i < len; i++) {
						(selectedIds[i] != siblingsSelectedObjId) && testAttrIds.push(selectedIds[i]);
					}
				} else {
					testAttrIds = selectedIds.concat();
				}
				testAttrIds = testAttrIds.concat($(this).attr('attr_id'));
				testAttrIds.sort(function(value1, value2) {
					return parseInt(value1) - parseInt(value2);
				});
				if(!SKUResult[testAttrIds.join(';')]) {
				    $(this).addClass('notchoose')
					$(this).attr('disabled', 'disabled').removeClass('bh-sku-selected');
				} else {
				    $(this).removeClass('notchoose')
					$(this).removeAttr('disabled');
				}
			});
		} else {
			//设置默认价格
			$('#price').text('--');
			//设置属性状态
			$('.sku').each(function() {
				SKUResult[$(this).attr('attr_id')] ? $(this).removeAttr('disabled') : $(this).attr('disabled', 'disabled').removeClass('bh-sku-selected');
			})
		}
	});
});
JS;
$this->registerJS($js);
?>
</script>

<div>
属性1：
<input type="button" class="sku" attr_id="10" value="10"/>
</div>

<div>
属性2：
<input type="button" class="sku" attr_id="20" value="20"/>
<input type="button" class="sku" attr_id="21" value="21"/>
<input type="button" class="sku" attr_id="22" value="22"/>
<input type="button" class="sku" attr_id="23" value="23"/>
<input type="button" class="sku" attr_id="24" value="24"/>
</div>

<div>
属性3：
<input type="button" class="sku" attr_id="30" value="30"/>
<input type="button" class="sku" attr_id="31" value="31"/>
<input type="button" class="sku" attr_id="32" value="32"/>
<input type="button" class="sku" attr_id="33" value="33"/>
<input type="button" class="sku" attr_id="34" value="34"/>
<input type="button" class="sku" attr_id="35" value="35"/>
<input type="button" class="sku" attr_id="36" value="36"/>
<input type="button" class="sku" attr_id="37" value="37"/>
<input type="button" class="sku" attr_id="38" value="38"/>
</div>

<div>
属性4：
<input type="button" class="sku" attr_id="40" value="40"/>
</div>

<span id="init_time">init sku time: </span> </br>
<span id="price">--</span> </br>
<pre class="brush: js;">
//销售属性集
var keys = [
        ['10'],
        ['20','21','22','23','24'],
        ['30','31','32','33','34','35','36','37','38'],
        ['40']
        ];

//后台读取结果集
var data = {
    "10;24;31;40": {
        price:366,
        count:46
    },
    "10;24;32;40": {
        price:406,
        count:66
    },
    "10;24;33;40": {
        price:416,
        count:77
    },
    "10;24;34;40": {
        price:456,
        count:9
    },
    "10;24;35;40": {
        price:371,
        count:33
    },
    "10;24;36;40": {
        price:411,
        count:79
    },
    "10;24;37;40": {
        price:421,
        count:87
    },
    "10;24;38;40": {
        price:461,
        count:9
    },
    "10;24;30;40": {
        price:356,
        count:59
    },
    "10;23;31;40": {
        price:366,
        count:50
    },
    "10;23;32;40": {
        price:406,
        count:9
    },
    "10;23;33;40": {
        price:416,
        count:90
    },
    "10;23;34;40": {
        price:456,
        count:10
    },
    "10;23;35;40": {
        price:371,
        count:79
    },
    "10;23;36;40": {
        price:411,
        count:90
    },
    "10;23;37;40": {
        price:421,
        count:10
    },
    "10;23;38;40": {
        price:461,
        count:9
    },
    "10;23;30;40": {
        price:356,
        count:46
    },
    "10;22;31;40": {
        price:356,
        count:27
    },
    "10;22;32;40": {
        price:396,
        count:38
    },
    "10;22;33;40": {
        price:406,
        count:42
    },
    "10;22;34;40": {
        price:446,
        count:50
    },
    "10;22;35;40": {
        price:361,
        count:25
    },
    "10;22;36;40": {
        price:401,
        count:40
    },
    "10;22;37;40": {
        price:411,
        count:43
    },
    "10;22;38;40": {
        price:451,
        count:42
    },
    "10;21;31;40": {
        price:366,
        count:79
    },
    "10;21;32;40": {
        price:406,
        count:79
    },
    "10;21;33;40": {
        price:416,
        count:10
    },
    "10;21;34;40": {
        price:456,
        count:10
    },
    "10;21;35;40": {
        price:371,
        count:87
    },
    "10;21;36;40": {
        price:411,
        count:10
    },
    "10;21;37;40": {
        price:421,
        count:10
    },
    "10;21;38;40": {
        price:461,
        count:80
    },
    "10;21;30;40": {
        price:356,
        count:43
    },
    "10;20;31;40": {
        price:356,
        count:46
    },
    "10;20;32;40": {
        price:396,
        count:49
    },
    "10;20;33;40": {
        price:406,
        count:65
    },
    "10;20;34;40": {
        price:446,
        count:10
    },
    "10;20;35;40": {
        price:361,
        count:34
    },
    "10;20;36;40": {
        price:401,
        count:41
    },
    "10;20;37;40": {
        price:411,
        count:36
    },
    "10;20;38;40": {
        price:451,
        count:42
    },
    "10;20;30;40": {
        price:346,
        count: 3
    }
}
</pre>
</span>

