//editable cell - reorder and delete
class ViewController: UIViewController, UITableViewDelegate, UITableViewDataSource {
    @IBOutlet weak var tableView: UITableView!
    var movies = ["lion", "kgf","moonknight"]

    func tableview(_ tableview: UITableView, numberOfRowsInSection section: Int) -> Int {
        return movies.count
    }
    
    func tableview(_ tableview: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        let cell - tableview.dequeReusableCell(withIdentifier: "movieCell", for: indexPath)
        cell.textLabel?.text = movies[indexPath.item]
        return cell
    }

    func tableView(_ tableview: UITableView, moveRowAt sourceIndexPath: IndexPath, to destinationIndexPath: IndexPath)
    {
        let movedObjTemp = movies[sourceIndexPath.item]
        movies.remove(at: sourceIndexPath.item)
        movies.insert(movedObjTemp, at: destinationIndexPath.item)
    }
    
    func tableView(_ tableview: UITableView, commit editingStyle: UITableViewCellEditingStyle, forRowAt indexPath: IndexPath)
    {
        if(editingStyle == .delete)
        {
            movies.remove(at: indexPath.item)
            tableView.deleteRows(at: [indexPath], woth: .automatic)
        }
    }

    @IBAction func editAction(_ sender: UIBarButtonItem)
    {
        self.tableView.isEditig = !self.tableView.isEditing
        sender.title = (self.tableView.isEditing) ? "Done" : "Edit"
    }
}

//UIAlertControll
func tbv(_, commit editingStyle: _
            forRowAt indexPath: IndexPath)
            {
                let item = movies.allItems[indexPath.row]
                let title = "Delete \(item.name)?"
                let msg = "Are you sure you want to delete this item?"
                let ac - UIAlertController(
                    title: title,
                    message: msg,
                    prefferedStyle: .actionSheet
                )

                let cancelAction = UIAlertAction(  
                    title: "Cancel",
                    Style: .cancel,
                    handler: nil
                )
                ac.addAction(cancelAction)

                let deleteAction = UIAlertAction(  
                    title: "Delete",
                    Style: .distruction,
                    handler: {(action) -> void indexPath
                    
                    self.movies.remove(at: indexPath.item)
                    self.tableView.deleteRows(
                        at: [indexPath],
                        with: .automatic
                    )}
                )
            }

//dessert- add/view
var desserts = [string]()

@IBAction func onAddTapped()
{
    let alert = UIAlertController(
        title: "Add Dessert",
        message: nil,
        prefferedStyle: .alert    )

        alert.addTextField{(dessertTF) in dessertTF.placeholder = "Enter dessert" }

        let action =UIAlertAction(
            title: "Add",
            Style: .default) {(______________) in
            guard let dessert = alert.textField?.first?.text else { return }

            self.add(dessert)
            
            }

            alert.addAction(action)
            present(alert, animation: true)
                  
}

func add(_ dessert: String)
{
    let index = 0
    desserts.insert(dessert, at: index)
    let indexPath = IndexPath(
        row: index,
        section: 0
    )
    tableView.insertRow(at: [indexPath], with: .left)
}

//camera
//swiftfile - name= takePicture
@IBAction func takePicture()
{
    let imagePicker = UIImagePickerController()
    if UIImagePicker.isSourceTypeAvailable(.camera)
    {
        imagePicker.sourceType = .camera
    }
    else{
        imagePicker.sourceType = .photoLibrary
        imagePicker.delegate = self
        present(imaagePicker, animate: true, completion : nil)
    }
}
func imagePickerController(__________)
{
    let image = info[UIImagePickerControllerOriginalImage] as !UIImage
    imageView.image = image
    dismiss(animated: true, completion: nil)
}

//quiz
import UIKit

class ViewController: UIViewController {

    @IBOutlet var questionLabel: UILabel!
    @IBOutlet var answerLabel: UILabel!
    
    let questions: [String] = [
    "What is 7 + 7 ?",
    "What is the capital of India ?",
    "What is iOS ?"
    ]
    let answers: [String] = [
    "14",
    "New Delhi",
    "iPhone Operation System"
    ]
    var currentQuestionIndex: Int = 0
    
    
    @IBAction func showNextQuestion(_ sender: UIButton){
        currentQuestionIndex += 1
        if(currentQuestionIndex == questions.count){
            currentQuestionIndex = 0
        }
        
        let question: String = questions[currentQuestionIndex]
        questionLabel.text = question
        answerLabel.text = "???"
    }
    @IBAction func showAnswer(_ sender: UIButton){
        let answer : String = answers[currentQuestionIndex]
        answerLabel.text = answer
    }
    
    override func viewDidLoad() {
        super.viewDidLoad()
        questionLabel.text = questions[currentQuestionIndex]
        // Do any additional setup after loading the view.
    }
}

//conevertion view controller
import UIKit

class ConversionViewController : UIViewController, UITextFieldDelegate {
    
    let numberFormatter: NumberFormatter = {
        let nf = NumberFormatter()
        nf.numberStyle = .decimal
        nf.minimumFractionDigits = 0
        nf.maximumFractionDigits = 1
        return nf
    }()
    @IBOutlet var inptext: UITextField!
    @IBOutlet var celciusLabel: UILabel!
    
    var farenheitValue: Measurement<UnitTemperature>?{
        didSet{
            updateCelciusLabel()
        }
    }
    var celciusValue: Measurement<UnitTemperature>? {
        if let farenheitValue = farenheitValue {
            return farenheitValue.converted(to: .celsius)
        }
        else{
            return nil
        }
    }
    func updateCelciusLabel(){
        if let celciusValue = celciusValue {
//            celciusLabel.text = "\(celciusValue.value)"
            celciusLabel.text = numberFormatter.string(from: NSNumber(value: celciusValue.value))
        }
        else{
            return celciusLabel.text = "???"
        }
    }
    
    
    @IBAction func farenheitFieldEditingChanged(_ textfield: UITextField){
//        celciusLabel.text = textfield.text
//        if let text = textfield.text, !text.isEmpty{
//            celciusLabel.text = text
//        }
//        else{
//            celciusLabel.text = "???"
//        }
        if let text = inptext.text, let value = Double(text){
            farenheitValue = Measurement(value: value, unit: .fahrenheit)
        }
        else{
            farenheitValue = nil
        }
    }
    @IBAction func dismissKeyboard(_ sender: UITapGestureRecognizer) {
        inptext.resignFirstResponder()
    }
    override func viewDidLoad() {
        updateCelciusLabel()
    }
    
    func textField(_ textField: UITextField,
                   shouldChangeCharactersIn range: NSRange,
                   replacementString string: String) -> Bool {
//        print("Current Text: \(textField.text)")
//        print("Replacement Text: \(string)")
        let existingTextHasDecimalSeparator = textField.text?.range(of: ".")
        let replacementTextHasDecimalSeparator = string.range(of: ".")
        
        if existingTextHasDecimalSeparator != nil, replacementTextHasDecimalSeparator != nil{
            return false
        }
        else{
            return true
        }
    }
    
}

//map programmatically
import UIKit
import MapKit
class MapViewController: UIViewController {
    var mapView: MKMapView!
    override func loadView() {
        // Create a map view
        mapView = MKMapView()
        // Set it as *the* view of this view controller
        view = mapView
    }
    override func viewDidLoad() {
        super.viewDidLoad()
        print("MapViewController loaded its view.")
    }
}

//enum and switch stmt
enum PieType {
 case apple
 case cherry
 case pecan
}
let favoritePie = PieType.apple
let name: String
switch favoritePie {
case .apple:
 name = "Apple"
case .cherry:
 name = "Cherry"
case .pecan:
 name = "Pecan"
}

//views and frames
import UIKit
class ViewController: UIViewController {
        override func viewDidLoad() {
            super.viewDidLoad()
            let firstFrame = CGRect(x: 160, y: 240, width: 100, height: 150)
            let firstView = UIView(frame: firstFrame)
            firstView.backgroundColor = UIColor.blue
            view.addSubview(firstView)

            let secondFrame = CGRect(x: 20, y: 30, width: 50, height: 50)
            let secondView = UIView(frame: secondFrame)
            secondView.backgroundColor = UIColor.green
            //view.addSubview(secondView)
            firstView.addSubview(secondView)
}

}
