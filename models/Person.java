package models;

public class Person implements Displayable {
    private String name;

    public Person(String name) {
        this.name = name;
    }

    public String getName() {
        return name;
    }

    
    public void displayInfo() {
        System.out.println("Name: " + name);
    }
}
