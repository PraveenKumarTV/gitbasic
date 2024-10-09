package models;

public class Student extends Person {
    private String email;
    private int graduationYear;
    private String studentId;
    private double gpa;
    private double scholarshipAmount;

    public Student(String name, String email, int graduationYear, String studentId, double gpa, double scholarshipAmount) {
        super(name);
        this.email = email;
        this.graduationYear = graduationYear;
        this.studentId = studentId;
        this.gpa = gpa;
        this.scholarshipAmount = scholarshipAmount;
    }

    @Override
    public void displayInfo() {
        super.displayInfo();
        System.out.println("Email: " + email);
        System.out.println("Graduation Year: " + graduationYear);
        System.out.println("GPA: " + gpa);
        System.out.println("Scholarship Amount: " + scholarshipAmount);
    }

    public String getStudentId() {
        return studentId;
    }
}
