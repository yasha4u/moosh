<?php
/**
 * moosh - Moodle Shell
 *
 * @copyright  2012 onwards Tomasz Muras
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace Moosh\Command\Moodle39\Category;
use Moosh\MooshCommand;

class CategoryCreate extends MooshCommand
{
    public function __construct()
    {
        parent::__construct('create', 'category');

        $this->addOption('d|description:', 'description');
        $this->addOption('p|parent:', 'format');
        $this->addOption('i|idnumber:', 'idnumber');
        $this->addOption('v|visible:', 'visible');
        $this->addOption('r|reuse', 'reuse existing category if it is the only matching one', false);

        $this->addArgument('name');

        $this->maxArguments = 255;
    }

    public function execute()
    {
        foreach ($this->arguments as $argument) {
            $this->expandOptionsManually(array($argument));
            $options = $this->expandedOptions;

            $category = new \stdClass();
            $category->name = $argument;
            $category->description = $options['description'];
            $category->parent = $options['parent'];
            $category->idnumber = $options['idnumber'];
            $category->visible = $options['visible'];

            if($this->verbose) {
                $name = $category->name;
                mtrace("Creating category $name");
            }

            if ($options['reuse'] && $existing = $this->find_category($category)) {
                $newcategory = $existing;

                $name = $newcategory->name;
                $id = $newcategory->id;
                print "Category $name with id: $id exists. Skipping, because --reuse param is present.\n";
            } else {
                $newcategory = $this->create_category($category);

                $name = $newcategory->name;
                $id = $newcategory->id;
                print "Created category $name with id: $id.\n";
            }
        }
    }

    protected function create_category($category)
    {
        return \core_course_category::create($category);
    }

    protected function find_category($category)
    {
        global $DB;
        $params = array('name' => $category->name);
        $select = "name = :name";
        foreach (array('idnumber', 'parent') as $param) {
            if ($category->$param !== "") {
                $params[$param] = $category->$param;
                $select .= " AND $param = :$param";
            }
        }

        // description is of text type, so requires sql_compare_text to be found and do not throw
        if($category->description !== "") {
            $params["description"] = $category->description;
            $select .= "AND " . $DB->sql_compare_text('description') . " = :description";
        }


        $categories = $DB->get_records_select('course_categories', $select, $params);

        // sometimes more than one category might exist
        if (count($categories) >= 1) {
            return array_pop($categories);
        } else {
            return null;
        }
    }

}