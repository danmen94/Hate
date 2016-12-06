<?php

return <<<'VALUE'
"namespace IPS\\Theme;\nclass class_rules_admin_help extends \\IPS\\Theme\\Template\n{\n\t\t\tfunction overview(  ) {\n\t\t$return = '';\n\t\t$return .= <<<CONTENT\n\n\n<div class=\"ipsPad\" style=\"font-size:1.1em; line-height:1.4em; max-height:800px; overflow-y:scroll;\">\n\t\n\t<h3>Rules Overview<\/h3>\n\t<p>The rules application allows you to customize or &ldquo;program&rdquo; almost any behavior of your site through simple &ldquo;rules&rdquo; you set up through your ACP. You can create rules to automate tasks, manipulate content, update member profiles, and perform multitudes of other operations on your site based on events or conditions.<\/p>\n\t<p>There are three main components to every rule.<\/p>\n\t<ul>\n\t<li>Event<\/li>\n\t<li>Conditions<\/li>\n\t<li>Actions<\/li>\n\t<\/ul>\n\t\n\t<h3>Rule Events<\/h3>\n\t<p>When you create a rule, you will choose an event that will trigger the rule to be evaluated. There are many different core events that ship with the Rules application, but events can also be added by other 3<sup>rd<\/sup> party applications to give you specific control over features that may not be in core.<\/p>\n\t<p>For example, if you wanted to perform an action on some specific content after it is created, you could begin by creating a rule that is triggered when &ldquo;content is created&rdquo;.<\/p>\n\t\n\t<h3>Rule Conditions<\/h3>\n\t<p>As you typically don&rsquo;t want every rule you create to take action in every circumstance, you should create &ldquo;conditions&rdquo; for when the rule&rsquo;s actions will be executed. Conditions can be as simple or elaborate as you need in order to target the rule for your specific case.<\/p>\n\t<p>Following from the example above, if you want to automatically feature new content that is created by members from an &ldquo;expert&rdquo; group, you would create a condition that the &ldquo;content author&rdquo; is part of the &ldquo;expert&rdquo; member group.<\/p>\n\t\n\t<h3>Rule Actions<\/h3>\n\t<p>Once a rule has been triggered, and assuming its conditions have been met, the actions assigned to the rule will be invoked. Each rule can have one or more actions assigned to it which will be executed in order to complete the rule objectives. Actions can also be scheduled to execute at some time in the future rather than immediately.<\/p>\n\t<p>From the example above, in order to feature the content, you could add the &ldquo;feature content&rdquo; action to your rule. You then might add another action to &ldquo;unfeature the content&rdquo;, a week in the future.<\/p>\n\t\n\t<h3>Rule Groups<\/h3>\n\t<p>When a rule is added as a &ldquo;linked rule&rdquo; to another rule, they together become a &ldquo;rule group&rdquo;. The purpose of a rule group is simple. It allows multiple actions to be executed on the same event, but based on different condition requirements. It also allows you to conditionally execute rules based on whether their parent rule conditions have been met.<\/p>\n\t<p>The event that is assigned to the parent rule in the group is shared among all of the linked rules. In essence, linked rules are &ldquo;subrules&rdquo; to their parent rule. Subrules can in turn have their own linked rules which create rule groups inside of rule groups. This allows any complexity of rule condition\/action schemes to be achieved to fit your needs.<\/p>\n\t\n\t<h3>Rule Sets<\/h3>\n\t<p>Rule sets are like categories for your rules and rule groups. It allows you to organize your rules into logical &ldquo;sets&rdquo; of related functionality for easier management. Rule sets do not affect the control flow of rules in any way other than the fact that you can enable\/disable entire groups of rule functionality by enabling\/disabling the rule set they belong to.<\/p>\n\t\n\t<h3>Custom Actions<\/h3>\n\t<p>The rules application allows you to build your own custom actions which can be triggered by other rules and system events. Just like &ldquo;stock&rdquo; actions built into the rules application, you can define &ldquo;arguments&rdquo; for your custom actions which need to be provided whenever your custom action is triggered.<\/p>\n\t<p>Once you&rsquo;ve defined a custom action, it is available as an action inside your rules, and also as an event for which new rules can be created. This way you can control WHEN the custom action is invoked (using rules), and also WHAT HAPPENS when it is invoked (using rules).<\/p>\n\t\n\t<h3>Custom Data Fields<\/h3>\n\t<p>Rules gives you the ability to attach \"custom data\" fields to any member, node, or content item in the system. This data can then be manipulated in rules and even displayed or used in template logic on the front end.<\/p>\n\t\n\t<h3>Debugging<\/h3>\n\t<p>When rules aren&rsquo;t behaving the way you expect them to, it can be very helpful to look into the details related to when the rule is being triggered, what the result of the conditions assigned to it are, and what the result of the actions are when they are performed. If you enable the option to &ldquo;debug this rule&rdquo; on the configuration page for any given rule, then information regarding the execution of that rule will be logged to the Rules Log for you to inspect.<\/p>\n\t<p>Rules that have debugging turned on will also have a &ldquo;debug console&rdquo; available on their configuration form which shows all recent debug logs related specifically to that rule.<\/p>\n\t\n\t<h3>Scheduled Actions<\/h3>\n\t<p>As mentioned previously, any action assigned to a rule can be configured to execute at some point in the future rather than immediately. You may choose a set amount of time into the future (such as a day, or a week), or you may specify a specific fixed date, or you may use your own code to calculate a date\/time for the action to be executed.<\/p>\n\t<p>Actions that have been scheduled will appear in the &ldquo;Scheduled Actions&rdquo; portion of your ACP in the Rules management section. You can see a list of all upcoming scheduled actions, modify the scheduled action date, delete scheduled actions, or execute specific actions immediately instead of waiting for their scheduled date to arrive.<\/p>\n\n<\/div>\t\nCONTENT;\n\n\t\treturn $return;\n}}"
VALUE;
