<?php

/**
 * A helper file for Dcat Admin, to provide autocomplete information to your IDE
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author jqh <841324345@qq.com>
 */
namespace Dcat\Admin {
    use Illuminate\Support\Collection;

    /**
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection alias
     * @property Grid\Column|Collection authors
     * @property Grid\Column|Collection enable
     * @property Grid\Column|Collection imported
     * @property Grid\Column|Collection config
     * @property Grid\Column|Collection require
     * @property Grid\Column|Collection require_dev
     * @property Grid\Column|Collection textarea
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection path
     * @property Grid\Column|Collection method
     * @property Grid\Column|Collection ip
     * @property Grid\Column|Collection input
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection create_time
     * @property Grid\Column|Collection update_time
     * @property Grid\Column|Collection userpass
     * @property Grid\Column|Collection auto_open
     * @property Grid\Column|Collection game_house
     * @property Grid\Column|Collection game_type
     * @property Grid\Column|Collection max_trx
     * @property Grid\Column|Collection max_usd
     * @property Grid\Column|Collection min_trx
     * @property Grid\Column|Collection min_usd
     * @property Grid\Column|Collection odds
     * @property Grid\Column|Collection to_address
     * @property Grid\Column|Collection code
     * @property Grid\Column|Collection daili_num
     * @property Grid\Column|Collection group_num
     * @property Grid\Column|Collection huiyuan_num
     * @property Grid\Column|Collection one
     * @property Grid\Column|Collection two
     * @property Grid\Column|Collection hot_address
     * @property Grid\Column|Collection hot_key
     * @property Grid\Column|Collection limit_amount
     * @property Grid\Column|Collection coin_code
     * @property Grid\Column|Collection fenhong_amonut
     * @property Grid\Column|Collection from_address
     * @property Grid\Column|Collection remark
     * @property Grid\Column|Collection height
     * @property Grid\Column|Collection node
     * @property Grid\Column|Collection hash
     * @property Grid\Column|Collection hash_last
     * @property Grid\Column|Collection huikuan_amount
     * @property Grid\Column|Collection open_status
     * @property Grid\Column|Collection open_time
     * @property Grid\Column|Collection put_amount
     * @property Grid\Column|Collection shuying_amount
     * @property Grid\Column|Collection wanjia_open_str
     * @property Grid\Column|Collection win_status
     * @property Grid\Column|Collection zhuang_open_str
     * @property Grid\Column|Collection fenhong_status
     * @property Grid\Column|Collection order_id
     * @property Grid\Column|Collection amount
     * @property Grid\Column|Collection receive_address
     * @property Grid\Column|Collection send_status
     * @property Grid\Column|Collection status
     * @property Grid\Column|Collection tx_id
     * @property Grid\Column|Collection private_key
     * @property Grid\Column|Collection public_key
     * @property Grid\Column|Collection address_hex
     * @property Grid\Column|Collection address_base58
     * @property Grid\Column|Collection createtime
     * @property Grid\Column|Collection address
     * @property Grid\Column|Collection father_id
     * @property Grid\Column|Collection fenhong_balance
     * @property Grid\Column|Collection fenyong_enable
     * @property Grid\Column|Collection jiesuan_enable
     * @property Grid\Column|Collection level
     * @property Grid\Column|Collection my_code
     * @property Grid\Column|Collection group_chain
     * @property Grid\Column|Collection group_total
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection bot_token
     * @property Grid\Column|Collection bot_id
     * @property Grid\Column|Collection can_join_groups
     * @property Grid\Column|Collection can_read_all_group_messages
     * @property Grid\Column|Collection supports_inline_queries
     * @property Grid\Column|Collection chat_id
     * @property Grid\Column|Collection btntext
     * @property Grid\Column|Collection keywordid
     * @property Grid\Column|Collection group_id
     * @property Grid\Column|Collection count_down
     * @property Grid\Column|Collection key_id
     * @property Grid\Column|Collection keyword
     * @property Grid\Column|Collection file_id
     * @property Grid\Column|Collection content
     * @property Grid\Column|Collection images
     *
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection alias(string $label = null)
     * @method Grid\Column|Collection authors(string $label = null)
     * @method Grid\Column|Collection enable(string $label = null)
     * @method Grid\Column|Collection imported(string $label = null)
     * @method Grid\Column|Collection config(string $label = null)
     * @method Grid\Column|Collection require(string $label = null)
     * @method Grid\Column|Collection require_dev(string $label = null)
     * @method Grid\Column|Collection textarea(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection path(string $label = null)
     * @method Grid\Column|Collection method(string $label = null)
     * @method Grid\Column|Collection ip(string $label = null)
     * @method Grid\Column|Collection input(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection create_time(string $label = null)
     * @method Grid\Column|Collection update_time(string $label = null)
     * @method Grid\Column|Collection userpass(string $label = null)
     * @method Grid\Column|Collection auto_open(string $label = null)
     * @method Grid\Column|Collection game_house(string $label = null)
     * @method Grid\Column|Collection game_type(string $label = null)
     * @method Grid\Column|Collection max_trx(string $label = null)
     * @method Grid\Column|Collection max_usd(string $label = null)
     * @method Grid\Column|Collection min_trx(string $label = null)
     * @method Grid\Column|Collection min_usd(string $label = null)
     * @method Grid\Column|Collection odds(string $label = null)
     * @method Grid\Column|Collection to_address(string $label = null)
     * @method Grid\Column|Collection code(string $label = null)
     * @method Grid\Column|Collection daili_num(string $label = null)
     * @method Grid\Column|Collection group_num(string $label = null)
     * @method Grid\Column|Collection huiyuan_num(string $label = null)
     * @method Grid\Column|Collection one(string $label = null)
     * @method Grid\Column|Collection two(string $label = null)
     * @method Grid\Column|Collection hot_address(string $label = null)
     * @method Grid\Column|Collection hot_key(string $label = null)
     * @method Grid\Column|Collection limit_amount(string $label = null)
     * @method Grid\Column|Collection coin_code(string $label = null)
     * @method Grid\Column|Collection fenhong_amonut(string $label = null)
     * @method Grid\Column|Collection from_address(string $label = null)
     * @method Grid\Column|Collection remark(string $label = null)
     * @method Grid\Column|Collection height(string $label = null)
     * @method Grid\Column|Collection node(string $label = null)
     * @method Grid\Column|Collection hash(string $label = null)
     * @method Grid\Column|Collection hash_last(string $label = null)
     * @method Grid\Column|Collection huikuan_amount(string $label = null)
     * @method Grid\Column|Collection open_status(string $label = null)
     * @method Grid\Column|Collection open_time(string $label = null)
     * @method Grid\Column|Collection put_amount(string $label = null)
     * @method Grid\Column|Collection shuying_amount(string $label = null)
     * @method Grid\Column|Collection wanjia_open_str(string $label = null)
     * @method Grid\Column|Collection win_status(string $label = null)
     * @method Grid\Column|Collection zhuang_open_str(string $label = null)
     * @method Grid\Column|Collection fenhong_status(string $label = null)
     * @method Grid\Column|Collection order_id(string $label = null)
     * @method Grid\Column|Collection amount(string $label = null)
     * @method Grid\Column|Collection receive_address(string $label = null)
     * @method Grid\Column|Collection send_status(string $label = null)
     * @method Grid\Column|Collection status(string $label = null)
     * @method Grid\Column|Collection tx_id(string $label = null)
     * @method Grid\Column|Collection private_key(string $label = null)
     * @method Grid\Column|Collection public_key(string $label = null)
     * @method Grid\Column|Collection address_hex(string $label = null)
     * @method Grid\Column|Collection address_base58(string $label = null)
     * @method Grid\Column|Collection createtime(string $label = null)
     * @method Grid\Column|Collection address(string $label = null)
     * @method Grid\Column|Collection father_id(string $label = null)
     * @method Grid\Column|Collection fenhong_balance(string $label = null)
     * @method Grid\Column|Collection fenyong_enable(string $label = null)
     * @method Grid\Column|Collection jiesuan_enable(string $label = null)
     * @method Grid\Column|Collection level(string $label = null)
     * @method Grid\Column|Collection my_code(string $label = null)
     * @method Grid\Column|Collection group_chain(string $label = null)
     * @method Grid\Column|Collection group_total(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection bot_token(string $label = null)
     * @method Grid\Column|Collection bot_id(string $label = null)
     * @method Grid\Column|Collection can_join_groups(string $label = null)
     * @method Grid\Column|Collection can_read_all_group_messages(string $label = null)
     * @method Grid\Column|Collection supports_inline_queries(string $label = null)
     * @method Grid\Column|Collection chat_id(string $label = null)
     * @method Grid\Column|Collection btntext(string $label = null)
     * @method Grid\Column|Collection keywordid(string $label = null)
     * @method Grid\Column|Collection group_id(string $label = null)
     * @method Grid\Column|Collection count_down(string $label = null)
     * @method Grid\Column|Collection key_id(string $label = null)
     * @method Grid\Column|Collection keyword(string $label = null)
     * @method Grid\Column|Collection file_id(string $label = null)
     * @method Grid\Column|Collection content(string $label = null)
     * @method Grid\Column|Collection images(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection name
     * @property Show\Field|Collection version
     * @property Show\Field|Collection alias
     * @property Show\Field|Collection authors
     * @property Show\Field|Collection enable
     * @property Show\Field|Collection imported
     * @property Show\Field|Collection config
     * @property Show\Field|Collection require
     * @property Show\Field|Collection require_dev
     * @property Show\Field|Collection textarea
     * @property Show\Field|Collection type
     * @property Show\Field|Collection id
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection order
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection path
     * @property Show\Field|Collection method
     * @property Show\Field|Collection ip
     * @property Show\Field|Collection input
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection username
     * @property Show\Field|Collection password
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection create_time
     * @property Show\Field|Collection update_time
     * @property Show\Field|Collection userpass
     * @property Show\Field|Collection auto_open
     * @property Show\Field|Collection game_house
     * @property Show\Field|Collection game_type
     * @property Show\Field|Collection max_trx
     * @property Show\Field|Collection max_usd
     * @property Show\Field|Collection min_trx
     * @property Show\Field|Collection min_usd
     * @property Show\Field|Collection odds
     * @property Show\Field|Collection to_address
     * @property Show\Field|Collection code
     * @property Show\Field|Collection daili_num
     * @property Show\Field|Collection group_num
     * @property Show\Field|Collection huiyuan_num
     * @property Show\Field|Collection one
     * @property Show\Field|Collection two
     * @property Show\Field|Collection hot_address
     * @property Show\Field|Collection hot_key
     * @property Show\Field|Collection limit_amount
     * @property Show\Field|Collection coin_code
     * @property Show\Field|Collection fenhong_amonut
     * @property Show\Field|Collection from_address
     * @property Show\Field|Collection remark
     * @property Show\Field|Collection height
     * @property Show\Field|Collection node
     * @property Show\Field|Collection hash
     * @property Show\Field|Collection hash_last
     * @property Show\Field|Collection huikuan_amount
     * @property Show\Field|Collection open_status
     * @property Show\Field|Collection open_time
     * @property Show\Field|Collection put_amount
     * @property Show\Field|Collection shuying_amount
     * @property Show\Field|Collection wanjia_open_str
     * @property Show\Field|Collection win_status
     * @property Show\Field|Collection zhuang_open_str
     * @property Show\Field|Collection fenhong_status
     * @property Show\Field|Collection order_id
     * @property Show\Field|Collection amount
     * @property Show\Field|Collection receive_address
     * @property Show\Field|Collection send_status
     * @property Show\Field|Collection status
     * @property Show\Field|Collection tx_id
     * @property Show\Field|Collection private_key
     * @property Show\Field|Collection public_key
     * @property Show\Field|Collection address_hex
     * @property Show\Field|Collection address_base58
     * @property Show\Field|Collection createtime
     * @property Show\Field|Collection address
     * @property Show\Field|Collection father_id
     * @property Show\Field|Collection fenhong_balance
     * @property Show\Field|Collection fenyong_enable
     * @property Show\Field|Collection jiesuan_enable
     * @property Show\Field|Collection level
     * @property Show\Field|Collection my_code
     * @property Show\Field|Collection group_chain
     * @property Show\Field|Collection group_total
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection email
     * @property Show\Field|Collection token
     * @property Show\Field|Collection bot_token
     * @property Show\Field|Collection bot_id
     * @property Show\Field|Collection can_join_groups
     * @property Show\Field|Collection can_read_all_group_messages
     * @property Show\Field|Collection supports_inline_queries
     * @property Show\Field|Collection chat_id
     * @property Show\Field|Collection btntext
     * @property Show\Field|Collection keywordid
     * @property Show\Field|Collection group_id
     * @property Show\Field|Collection count_down
     * @property Show\Field|Collection key_id
     * @property Show\Field|Collection keyword
     * @property Show\Field|Collection file_id
     * @property Show\Field|Collection content
     * @property Show\Field|Collection images
     *
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection alias(string $label = null)
     * @method Show\Field|Collection authors(string $label = null)
     * @method Show\Field|Collection enable(string $label = null)
     * @method Show\Field|Collection imported(string $label = null)
     * @method Show\Field|Collection config(string $label = null)
     * @method Show\Field|Collection require(string $label = null)
     * @method Show\Field|Collection require_dev(string $label = null)
     * @method Show\Field|Collection textarea(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection path(string $label = null)
     * @method Show\Field|Collection method(string $label = null)
     * @method Show\Field|Collection ip(string $label = null)
     * @method Show\Field|Collection input(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection create_time(string $label = null)
     * @method Show\Field|Collection update_time(string $label = null)
     * @method Show\Field|Collection userpass(string $label = null)
     * @method Show\Field|Collection auto_open(string $label = null)
     * @method Show\Field|Collection game_house(string $label = null)
     * @method Show\Field|Collection game_type(string $label = null)
     * @method Show\Field|Collection max_trx(string $label = null)
     * @method Show\Field|Collection max_usd(string $label = null)
     * @method Show\Field|Collection min_trx(string $label = null)
     * @method Show\Field|Collection min_usd(string $label = null)
     * @method Show\Field|Collection odds(string $label = null)
     * @method Show\Field|Collection to_address(string $label = null)
     * @method Show\Field|Collection code(string $label = null)
     * @method Show\Field|Collection daili_num(string $label = null)
     * @method Show\Field|Collection group_num(string $label = null)
     * @method Show\Field|Collection huiyuan_num(string $label = null)
     * @method Show\Field|Collection one(string $label = null)
     * @method Show\Field|Collection two(string $label = null)
     * @method Show\Field|Collection hot_address(string $label = null)
     * @method Show\Field|Collection hot_key(string $label = null)
     * @method Show\Field|Collection limit_amount(string $label = null)
     * @method Show\Field|Collection coin_code(string $label = null)
     * @method Show\Field|Collection fenhong_amonut(string $label = null)
     * @method Show\Field|Collection from_address(string $label = null)
     * @method Show\Field|Collection remark(string $label = null)
     * @method Show\Field|Collection height(string $label = null)
     * @method Show\Field|Collection node(string $label = null)
     * @method Show\Field|Collection hash(string $label = null)
     * @method Show\Field|Collection hash_last(string $label = null)
     * @method Show\Field|Collection huikuan_amount(string $label = null)
     * @method Show\Field|Collection open_status(string $label = null)
     * @method Show\Field|Collection open_time(string $label = null)
     * @method Show\Field|Collection put_amount(string $label = null)
     * @method Show\Field|Collection shuying_amount(string $label = null)
     * @method Show\Field|Collection wanjia_open_str(string $label = null)
     * @method Show\Field|Collection win_status(string $label = null)
     * @method Show\Field|Collection zhuang_open_str(string $label = null)
     * @method Show\Field|Collection fenhong_status(string $label = null)
     * @method Show\Field|Collection order_id(string $label = null)
     * @method Show\Field|Collection amount(string $label = null)
     * @method Show\Field|Collection receive_address(string $label = null)
     * @method Show\Field|Collection send_status(string $label = null)
     * @method Show\Field|Collection status(string $label = null)
     * @method Show\Field|Collection tx_id(string $label = null)
     * @method Show\Field|Collection private_key(string $label = null)
     * @method Show\Field|Collection public_key(string $label = null)
     * @method Show\Field|Collection address_hex(string $label = null)
     * @method Show\Field|Collection address_base58(string $label = null)
     * @method Show\Field|Collection createtime(string $label = null)
     * @method Show\Field|Collection address(string $label = null)
     * @method Show\Field|Collection father_id(string $label = null)
     * @method Show\Field|Collection fenhong_balance(string $label = null)
     * @method Show\Field|Collection fenyong_enable(string $label = null)
     * @method Show\Field|Collection jiesuan_enable(string $label = null)
     * @method Show\Field|Collection level(string $label = null)
     * @method Show\Field|Collection my_code(string $label = null)
     * @method Show\Field|Collection group_chain(string $label = null)
     * @method Show\Field|Collection group_total(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection bot_token(string $label = null)
     * @method Show\Field|Collection bot_id(string $label = null)
     * @method Show\Field|Collection can_join_groups(string $label = null)
     * @method Show\Field|Collection can_read_all_group_messages(string $label = null)
     * @method Show\Field|Collection supports_inline_queries(string $label = null)
     * @method Show\Field|Collection chat_id(string $label = null)
     * @method Show\Field|Collection btntext(string $label = null)
     * @method Show\Field|Collection keywordid(string $label = null)
     * @method Show\Field|Collection group_id(string $label = null)
     * @method Show\Field|Collection count_down(string $label = null)
     * @method Show\Field|Collection key_id(string $label = null)
     * @method Show\Field|Collection keyword(string $label = null)
     * @method Show\Field|Collection file_id(string $label = null)
     * @method Show\Field|Collection content(string $label = null)
     * @method Show\Field|Collection images(string $label = null)
     */
    class Show {}

    /**
     
     */
    class Form {}

}

namespace Dcat\Admin\Grid {
    /**
     
     */
    class Column {}

    /**
     
     */
    class Filter {}
}

namespace Dcat\Admin\Show {
    /**
     
     */
    class Field {}
}
